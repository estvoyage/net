<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world as net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\data,
	estvoyage\net\socket\error
;

class udp implements net\socket
{
	private
		$resource,
		$host,
		$port
	;

	function __construct(host $host, port $port)
	{
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

	function bufferWantToWait()
	{
		return $this->block(true);
	}

	function bufferDoNotWantToWait()
	{
		return $this->block(false);
	}

	function bufferContains(net\socket\buffer $buffer, data $data)
	{
		$dataLength = strlen($data);

		if (($bytesWritten = socket_sendto($this->connectToHost()->resource, $data, $dataLength, 0, $this->host, $this->port)) === false)
		{
			throw new exception(new error(new error\code(socket_last_error($this->resource))));
		}

		if ($bytesWritten < $dataLength)
		{
			$buffer->remainingData(new data(substr($data, $bytesWritten)));
		}

		return $this;
	}

	private function connectToHost()
	{
		if (! $this->resource && ! ($this->resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null))
		{
			throw new exception(new error(new error\code(socket_last_error($this->resource))));
		}

		return $this;
	}

	private function block($boolean)
	{
		$this->connectToHost();

		if (! ($boolean ? socket_set_block($this->resource) : socket_set_nonblock($this->resource)))
		{
			throw new exception(new error(new error\code(socket_last_error($this->resource))));
		}

		return $this;
	}
}
