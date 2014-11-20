<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class connection
{
	private
		$address,
		$socket,
		$observer
	;

	function __construct(net\address $address, net\socket $socket, net\socket\observer $observer)
	{
		$this->address = $address;
		$this->socket = $socket;
		$this->observer = $observer;
	}

	function send($data, $id = null)
	{
		$this->address->send($data, $this->socket, $this->observer, $id);

		return $this;
	}
}
