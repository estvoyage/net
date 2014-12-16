<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world as net,
	estvoyage\net\address,
	estvoyage\net\socket\data,
	estvoyage\net\socket\error
;

class udp implements net\socket
{
	private
		$resource,
		$address
	;

	function __construct(address $address)
	{
		$this->address = $address;
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

	function write(data $data)
	{
		$dataLength = strlen($data);

		switch (true)
		{
			case ! $this->resource && ! ($this->resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null):
			case ($bytesWritten = socket_sendto($this->resource, $data, $dataLength, 0, $this->address->host, $this->address->port)) === false:
				throw new exception(new error(new error\code(socket_last_error($this->resource))));

			case $bytesWritten < $dataLength:
				return new data(substr($data, $bytesWritten));

			default:
				return new data;
		}
	}

	function writeAll(data $data)
	{
		while ((string) $data)
		{
			$data = $this->write($data);
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
