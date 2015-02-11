<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net\socket\client
;

require __DIR__ . '/../socket.php';

class socket extends client\socket
{
	public
		$resource
	;

	function __construct($resource)
	{
		$this->resource = $resource;
	}
}
