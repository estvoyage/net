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

	function write($data, $host, $port, net\socket\observer $observer, $id = null)
	{
		$dataLength = strlen($data);

		switch (true)
		{
			case ! $this->resource && ! ($this->resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null):
			case ($bytesWritten = socket_sendto($this->resource, $data, $dataLength, 0, $host, $port)) === false:
				$observer->dataNotSentOnSocket($data, $id, socket_last_error($this->resource), $this);
				break;

			case $bytesWritten < $dataLength:
				$observer->dataNotFullySentOnSocket($data, $id, $bytesWritten, $this);
				break;

			default:
				$observer->dataSentOnSocket($data, $id, $this);
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
