<?php

namespace estvoyage\net\socket\client;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\data
;

abstract class socket implements data\consumer
{
	private
		$host,
		$port,
		$dataProvider
	;

	function __construct(host $host, port $port)
	{
		$this->host = $host;
		$this->port = $port;
	}

	function __destruct()
	{
		if (! $this->dataProvider)
		{
			$this->disconnect();
		}
	}

	final function dataProviderIs(data\provider $dataProvider)
	{
		$this->connectToHostAndPort($this->host, $this->port);

		$this
			->newDataProviderForHostAndPort($this->host, $this->port)
			->setDataProvider($dataProvider)
		;

		return $this;
	}

	function newData(data\data $data)
	{
		return $this->ifDataProvider(function() use ($data) {
				$this->writeData($data);
			}
		);
	}

	protected function lengthOfDataWrittenIs(data\data\length $length)
	{
		return $this->ifDataProvider(function() use ($length) {
				$this->dataProvider->lengthOfDataWrittenIs($length);
			}
		);
	}

	abstract protected function connectToHostAndPort(host $host, port $port);
	abstract protected function disconnect();
	abstract protected function newDataProviderForHostAndPort(host $host, port $port);
	abstract protected function writeData(data\data $data);

	private function setDataProvider(data\provider $dataProvider)
	{
		$this->dataProvider = $dataProvider;

		$dataProvider->useDataConsumer($this);

		return $this;
	}

	private function ifDataProvider(callable $callable)
	{
		if (! $this->dataProvider)
		{
			throw new exception\logic('Data provider is undefined');
		}

		$callable();

		return $this;
	}
}
