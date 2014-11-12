<?php

namespace estvoyage\net\endpoint;

use
	estvoyage\net\world\endpoint
;

class socket implements endpoint\socket
{
	private
		$protocol
	;

	function __construct(endpoint\socket\protocol $protocol)
	{
		$this->protocol = $protocol;
	}

	function connectHost($host)
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->connectHost($host);

		return $socket;
	}

	function connectPort($port)
	{
		$socket = clone $this;
		$socket->protocol = $this->protocol->connectPort($port);

		return $socket;
	}

	function write($data, callable $dataRemaining)
	{
		$this->protocol->write($data, $dataRemaining);

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
