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
		$socket,
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
		if ($this->socket)
		{
			socket_close($this->socket);
		}
	}

	function __clone()
	{
		if ($this->socket)
		{
			$this->socket = null;
		}
	}

	function bufferContains(net\socket\buffer $buffer, data $data)
	{
		$dataLength = strlen($data);

		if (($bytesWritten = socket_sendto($this->createSocket()->socket, $data, $dataLength, 0, $this->host, $this->port->asInteger)) === false)
		{
			throw new exception(new error(new error\code(socket_last_error($this->socket))));
		}

		if ($bytesWritten < $dataLength)
		{
			$buffer->remainingData(new data(substr($data, $bytesWritten)));
		}

		return $this;
	}

	private function createSocket()
	{
		if (! $this->socket && ! ($this->socket = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null))
		{
			throw new exception(new error(new error\code(socket_last_error($this->socket))));
		}

		return $this;
	}
}
