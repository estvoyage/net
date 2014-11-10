<?php

namespace estvoyage\net\endpoint;

use
	estvoyage\net\world as net
;

class connection implements net\endpoint\connection
{
	private
		$address
	;

	function __construct(net\endpoint\address $address)
	{
		$this->address = $address;
	}

	function connect(net\endpoint\address\component $component)
	{
		return $component->connectTo($this);
	}

	function connectHost($host)
	{
	}

	function connectPort($port)
	{
	}
}
