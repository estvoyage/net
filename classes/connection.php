<?php

namespace estvoyage\net\endpoint;

use
	estvoyage\net\world as net
;

class connection implements net\endpoint\connection
{
	private
		$socket
	;

	function __construct(net\endpoint\address $address, net\endpoint\socket\protocol $protocol)
	{
		$this->socket = $address->connect(new socket($protocol));
	}

	function connect(net\endpoint\address\component $component)
	{
		return $component->connect($this);
	}

	function connectHost($host)
	{
	}

	function connectPort($port)
	{
	}

	function write($data, callable $dataRemaining)
	{
		$this->socket->write($data, $dataRemaining);

		return $this;
	}
}
