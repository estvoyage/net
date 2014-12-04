<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\socket,
	estvoyage\net\address,
	estvoyage\net\socket\data,
	estvoyage\net\socket\error
;

class udp implements socket
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

	function write(data $data, address $address)
	{
		$dataLength = strlen($data);

		switch (true)
		{
			case ! $this->resource && ! ($this->resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null):
			case ($bytesWritten = socket_sendto($this->resource, $data, $dataLength, 0, $address->host, $address->port)) === false:
				throw new exception(new error(new error\code(socket_last_error($this->resource))));

			case $bytesWritten < $dataLength:
				return new data(substr($data, $bytesWritten));

			default:
				return new data;
		}
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
