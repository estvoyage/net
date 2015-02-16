<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net
;

class exception extends net\socket\exception
{
	public
		$socket
	;

	function __construct($socket = null)
	{
		$this->socket = $socket;
	}
}
