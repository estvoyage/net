<?php

namespace estvoyage\net\endpoint\socket;

use
	estvoyage\net\world\endpoint\socket,
	estvoyage\net\endpoint\socket\exception
;

class udp implements socket
{
	private
		$resource,
		$host,
		$port
	;

	function __construct($host, $port)
	{
		$this->resource = null;
		$this->host = $host;
		$this->port = $port;
	}

	function __destruct()
	{
		if ($this->resource)
		{
			socket_close($this->resource);
		}
	}

	function __clone()
	{
		$this->resource = null;
	}

	function write($data, callable $dataRemaining)
	{
		if (! $this->resource)
		{
			$resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

			if (! $resource)
			{
				$errorCode = socket_last_error($this->resource);

				throw new exception(socket_strerror(socket_last_error()), $errorCode);
			}

			$this->resource = $resource;
		}

		$bytesWritten = socket_sendto($this->resource, $data, strlen($data), 0, $this->host, $this->port);

		if ($bytesWritten === false)
		{
			$errorCode = socket_last_error($this->resource);

			throw new exception(socket_strerror($errorCode), $errorCode);
		}

		$dataRemaining(substr($data, $bytesWritten) ?: '');

		return $this;
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
}
