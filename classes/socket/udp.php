<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world as net
;

class udp implements net\socket
{
	private
		$resource
	;

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

	function write($data, $host, $port, net\socket\observer $observer)
	{
		$dataLength = strlen($data);

		if (! $this->resource)
		{
			$this->resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null;
		}

		switch (true)
		{
			case ! $this->resource:
			case ($bytesWritten = socket_sendto($this->resource, $data, $dataLength, 0, $host, $port)) === false:
				$observer->dataNotSent($data, $host, $port, socket_last_error($this->resource), $this);
				break;

			case $bytesWritten < $dataLength:
				$observer->dataNotFullySent($data, $host, $port, $bytesWritten, $this);
				break;

			default:
				$observer->dataSent($data, $host, $port, $this);
		}

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
