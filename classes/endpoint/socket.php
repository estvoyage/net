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

	function write($data, callable $dataRemaining)
	{
		$this->protocol->write($data, $dataRemaining);

		return $this;
	}

	function connectHost($host)
	{
		return $this->useProtocol($this->protocol->connectHost($host));
	}

	function connectPort($port)
	{
		return $this->useProtocol($this->protocol->connectPort($port));
	}

	function shutdown()
	{
		return $this->useProtocol($this->protocol->shutdown());
	}

	function shutdownOnlyReading()
	{
		return $this->useProtocol($this->protocol->shutdownOnlyReading());
	}

	function shutdownOnlyWriting()
	{
		return $this->useProtocol($this->protocol->shutdownOnlyWriting());
	}

	function disconnect()
	{
		return $this->useProtocol($this->protocol->disconnect());
	}

	private function useProtocol(endpoint\socket\protocol $protocol)
	{
		$socket = clone $this;
		$socket->protocol = $protocol;

		return $socket;
	}

}
