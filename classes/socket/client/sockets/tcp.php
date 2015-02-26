<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port
;

final class tcp extends socket
{
	function __construct(host $host, port $port)
	{
		parent::__construct($host, $port, AF_INET, SOCK_STREAM, SOL_TCP);
	}

	protected function newInstanceForHostAndPort(host $host, port $port)
	{
		return new self($host, $port);
	}
}
