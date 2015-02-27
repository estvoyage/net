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

	function __construct(host $host, port $port)
	{
		$this->host = $host;
		$this->port = $port;
	}

	function __destruct()
	{
		$this->disconnect();
	}

	final function newData(data\data $data)
	{
		$this->connectToHostAndPort($this->host, $this->port);
		$this->writeData($data);

		return $this;
	}

	final protected function lengthOfDataWrittenIs(data\data\length $length)
	{
		if ($this->controller)
		{
			$this->controller->lengthOfDataWrittenIs($length);
		}

		return $this;
	}

	abstract protected function connectToHostAndPort(host $host, port $port);
	abstract protected function writeData(data\data $data);
	abstract protected function disconnect();
}
