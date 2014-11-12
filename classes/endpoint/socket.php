<?php

namespace estvoyage\net\endpoint;

use
	estvoyage\net\world\endpoint
;

class socket implements endpoint\socket
{
	private
		$protocol,
		$host,
		$port
	;

	function __construct(endpoint\socket\protocol $protocol, $host = null, $port = null)
	{
		$this->protocol = $protocol;
		$this->host = $host;
		$this->port = $port;
	}

	function write($data, callable $dataRemaining)
	{
		$this->protocol->write($data, $this->host, $this->port, $dataRemaining);

		return $this;
	}

	function connectHost($host)
	{
		$socket = clone $this;
		$socket->host = $host;

		return $socket;
	}

	function connectPort($port)
	{
		$socket = clone $this;
		$socket->port = $port;

		return $socket;
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
