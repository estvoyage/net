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

	function shouldSend(data $data, net\socket\buffer $buffer)
	{
		$dataRemaining = $this->send($data);

		if ($dataRemaining)
		{
			$buffer->dataWasNotSent($dataRemaining);
		}

		return $this;
	}

	function mustSend(data $data)
	{
		while ((string) $data)
		{
			$data = $this->send($data);
		}

		return $this;
	}

	function noMoreDataToSend()
	{
		return $this;
	}

	function noMoreDataToReceive()
	{
		return $this;
	}

	function noMoreDataToSendOrReceive()
	{
		return $this;
	}

	function isNowUseless()
	{
		return $this;
	}

	private function send(data $data)
	{
		$dataLength = strlen($data);

		switch (true)
		{
			case ! $this->resource && ! ($this->resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP) ?: null):
			case ($bytesWritten = socket_sendto($this->resource, $data, $dataLength, 0, $this->address->host, $this->address->port)) === false:
				throw new exception(new error(new error\code(socket_last_error($this->resource))));
		}

		return $bytesWritten === $dataLength ? null : new data(substr($data, $bytesWritten));
	}
}
