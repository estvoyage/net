<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\data
;

abstract class socket extends net\socket\client\socket
{
	private
		$domain,
		$type,
		$protocol,
		$resource
	;

	function __construct(host $host, port $port, $domain, $type, $protocol)
	{
		parent::__construct($host, $port);

		$this->domain = $domain;
		$this->type = $type;
		$this->protocol = $protocol;
	}

	final function __clone()
	{
		$this->resource = null;
	}

	final protected function connectToHostAndPort(host $host, port $port)
	{
		if (! $this->resource)
		{
			$resource = socket_create($this->domain, $this->type, $this->protocol);

			if (! $resource)
			{
				throw new exception;
			}

			if (! socket_connect($resource, $host, $port->asInteger))
			{
				throw new exception($resource);
			}

			$this->resource = $resource;
		}
	}

	final protected function disconnect()
	{
		if ($this->resource)
		{
			socket_close($this->resource);
		}
	}

	final protected function writeData(data\data $data)
	{
		$bytesWritten = socket_send($this->resource, $data, strlen($data), 0);

		if ($bytesWritten === false)
		{
			throw new exception($this->resource);
		}

		$this->lengthOfDataWrittenIs(new data\data\length($bytesWritten));
	}

	final protected function newDataProviderForHostAndPort(host $host, port $port)
	{
		return $this
			->newInstanceForHostAndPort($host, $port)
			->setResource($this->resource)
		;
	}

	private function setResource($resource)
	{
		$this->resource = $resource;

		return $this;
	}
}
