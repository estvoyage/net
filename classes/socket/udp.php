<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world as net,
	estvoyage\net\byte,
	estvoyage\net\socket\data,
	estvoyage\net\socket\exception
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

	function write(net\socket\data $data, net\host $host, net\port $port)
	{
		$dataLength = strlen($data);

		if (! $this->resource)
		{
			$resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

			if (! $resource)
			{
				$this->data->failToSentTo($this, $host, $port, new byte\number($dataLength), socket_last_error());
			}

			$this->resource = $resource;
		}

		switch (true)
		{
			case ($bytesWritten = socket_sendto($this->resource, $data, $dataLength, 0, $host, $port)) === $dataLength:
				$data->successfullySentTo($this, $host, $port);
				break;

			default:
				$data->failToSentTo($this, $host, $port, new byte\number($bytesWritten), $bytesWritten !== false ? null : socket_last_error($this->resource));
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
