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
		$controller
	;

	function __construct(host $host, port $port, data\consumer\controller $controller = null)
	{
		$this->host = $host;
		$this->port = $port;
		$this->controller = $controller;
	}

	function __destruct()
	{
		$this->disconnect();
	}

	final function dataProviderIs(data\provider $dataProvider)
	{
		$dataProvider->dataConsumerIs($this);

		return $this;
	}

	final function newData(data\data $data)
	{
		$this->connectToHostAndPort($this->host, $this->port);
		$this->writeData($data);

		return $this;
	}

	final function noMoreData()
	{
		$this->disconnect();

		return $this;
	}

	final protected function dataNotWriteIs(data\data $data)
	{
		if ($this->controller)
		{
			$this->controller->dataNotWriteByDataConsumerIs($this, $data);
		}

		return $this;
	}

	abstract protected function connectToHostAndPort(host $host, port $port);
	abstract protected function writeData(data\data $data);
	abstract protected function disconnect();
}
