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

	function shutdown()
	{
		$this->protocol->shutdown();

		return $this;
	}

	function shutdownOnlyReading()
	{
		$this->protocol->shutdownOnlyReading();

		return $this;
	}

	function shutdownOnlyWriting()
	{
		$this->protocol->shutdownOnlyWriting();

		return $this;
	}

	function disconnect()
	{
		$this->protocol->disconnect();

		return $this;
	}
}
