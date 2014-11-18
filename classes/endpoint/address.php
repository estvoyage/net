<?php

namespace estvoyage\net\endpoint;

use
	estvoyage\net\world as net,
	estvoyage\net\world\endpoint
;

class address implements endpoint\address
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

	function send(net\socket\data $data, net\socket $socket)
	{
		$socket->write($data, $this->host, $this->port);

		return $this;
	}
}
