<?php

namespace estvoyage\net\socket\client;

use
	estvoyage\net\socket\client
;

class socket
{
	public
		$socket
	;

	function __construct($socket)
	{
		$this->socket = $socket;
	}
}
