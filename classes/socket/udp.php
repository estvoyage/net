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

	function write(net\socket\data $data, net\host $host, net\port $port, net\socket\data\offset $offset = null)
	{
		$offset = $offset ?: new data\offset(0);
		$dataString = substr($data, (string) $offset);
		$dataLength = strlen($dataString);

		if (! $this->resource)
		{
			$this->resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null;
		}

		switch (true)
		{
			case ! $this->resource:
			case ($bytesWritten = socket_sendto($this->resource, $dataString, $dataLength, 0, $host, $port)) === false:
				$data->notSentTo($this, $host, $port, $offset, new error(socket_last_error($this->resource)));
				break;

			case $bytesWritten < $dataLength:
				$data->notFullySentTo($this, $host, $port, $offset, new data\offset($dataLength - $bytesWritten));
				break;

			default:
				$data->sentTo($this, $host, $port);
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
