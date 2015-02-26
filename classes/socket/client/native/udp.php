<?php

namespace estvoyage\net\socket\client\native;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\error
;

final class udp extends socket
{
	function __construct(host $host, $port)
	{
		parent::__construct($host, $port, 'udp');
	}

	protected function newInstanceForHostAndPort(host $host, port $port)
	{
		return new self($host, $port);
	}
}
