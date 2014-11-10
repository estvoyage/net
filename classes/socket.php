<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class socket implements net\socket
{
	private
		$protocol
	;

	function __construct(net\socket\protocol $protocol)
	{
		$this->protocol = $protocol;
	}

	function connect(net\endpoint\address\component $component)
	{
		return $component->connectTo($this);
	}

	function connectHost($host)
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->connectHost($host);

		return $this;
	}

	function connectPort($port)
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->connectPort($port);

		return $this;
	}

	function writeData($data, callable $dataRemaining)
	{
		$this->protocol->writeData($data, $dataRemaining);

		return $this;
	}

	function write(net\socket\data $data)
	{
		try
		{
			$data->writeOn($this->protocol);
		}
		catch (\exception $exception)
		{
			throw new socket\exception($exception->getMessage());
		}

		return $this;
	}

	function shutdown()
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->shutdown();

		return $socket;
	}

	function shutdownOnlyReading()
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->shutdownOnlyReading();

		return $socket;
	}

	function shutdownOnlyWriting()
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->shutdownOnlyWriting();

		return $socket;
	}

	function disconnect()
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->disconnect();

		return $socket;
	}
}
