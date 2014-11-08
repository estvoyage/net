<?php

namespace estvoyage\net\socket\driver;

use
	estvoyage\net\world\socket,
	estvoyage\net\socket\driver
;

class udp implements socket\driver
{
	private
		$resource,
		$host,
		$port
	;

	function __construct($host, $port)
	{
		$this->init();

		$this->host = $host;
		$this->port = $port;
	}

	function __destruct()
	{
		socket_close($this->resource);
	}

	function __clone()
	{
		$this->init();
	}

	function connectTo($host, $port)
	{
		$driver = $this;

		if ($host != $this->host || $port != $this->port)
		{
			$driver = clone $this;
			$driver->host = $host;
			$driver->port = $port;
		}

		return $driver;
	}

	function write(socket\data $data)
	{
		$bytesWritten = socket_sendto($this->resource, $data, strlen($data), 0, $this->host, $this->port);

		if ($bytesWritten === false)
		{
			throw new driver\exception(socket_strerror(socket_last_error($this->resource)));
		}

		return $data->remove($bytesWritten);
	}

	function shutdown()
	{
		return $this;
	}

	function shutdownOnlyReading()
	{
		return $this;
	}

	function shutdownOnlyWriting()
	{
		return $this;
	}

	function disconnect()
	{
		return $this;
	}

	private function init()
	{
		$resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

		if (! $resource)
		{
			throw new driver\exception(socket_strerror(socket_last_error()));
		}

		$this->resource = $resource;

		return $this;
	}
}
