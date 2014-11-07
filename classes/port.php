<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class port implements net\port
{
	private
		$port
	;

	function __construct($port)
	{
		switch (true)
		{
			case ! $port:
			case $port < 0:
			case $port > 65535:
			case filter_var($port, FILTER_VALIDATE_INT) === false:
				throw new port\exception('\'' . $port . '\' is not a valid port');
		}

		$this->port = $port;
	}

	function connectSocket(net\socket $socket, $host)
	{
		return $socket->connectTo($host, $this->port);
	}
}
