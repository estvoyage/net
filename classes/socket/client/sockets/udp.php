<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\data
;

final class udp extends socket
{
	function __construct(host $host, port $port, data\consumer\controller $controller = null)
	{
		parent::__construct($host, $port, AF_INET, SOCK_DGRAM, SOL_UDP, $controller);
	}

	protected function newInstanceForHostAndPort(host $host, port $port)
	{
		return new self($host, $port);
	}
}
