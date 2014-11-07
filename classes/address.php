<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class address implements net\address
{
	private
		$host,
		$port
	;

	function __construct(net\host $host, net\port $port)
	{
		$this->host = $host;
		$this->port = $port;
	}

	function connectSocket(net\socket $socket)
	{
		return $this->host->connectSocket($socket, $this->port);
	}
}
