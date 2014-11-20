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

	function __construct($host, $port)
	{
		$this->host = $host;
		$this->port = $port;
	}

	function send($data, net\socket $socket, net\socket\observer $observer, $id = null)
	{
		$socket->write($data, $this->host, $this->port, $observer, $id);

		return $this;
	}
}
