<?php

namespace estvoyage\net\socket\protocol;

use
	estvoyage\net\world as net,
	estvoyage\net\world\socket,
	estvoyage\net\socket\protocol
;

class udp implements socket\protocol
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

	function connectHost($host)
	{
		$protocol = $this;

		if ($host != $this->host)
		{
			$protocol = clone $this;
			$protocol->host = $host;
		}

		return $protocol;
	}

	function connectPort($port)
	{
		$protocol = $this;

		if ($port != $this->port)
		{
			$protocol = clone $this;
			$protocol->port = $port;
		}

		return $protocol;
	}

	function writeData($data, callable $dataRemaining)
	{
		$bytesWritten = socket_sendto($this->resource, $data, strlen($data), 0, $this->host, $this->port);

		if ($bytesWritten === false)
		{
			throw new protocol\exception(socket_strerror(socket_last_error($this->resource)));
		}

		$dataRemaining(substr($data, $bytesWritten) ?: '');

		return $this;
	}

	function write(socket\data $data)
	{
		return $data->writeOn($this);
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
			throw new protocol\exception(socket_strerror(socket_last_error()));
		}

		$this->resource = $resource;

		return $this;
	}
}
