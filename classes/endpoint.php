<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class endpoint implements net\endpoint
{
	private
		$address,
		$socket
	;

	function __construct(net\endpoint\address $address, net\socket $socket)
	{
		$this->address = $address;
		$this->socket = $socket;
	}

	function send(net\socket\data $data)
	{
		$this->address->send($data, $this->socket);

		return $this;
	}
}
