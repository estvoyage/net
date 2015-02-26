<?php

namespace estvoyage\net\socket\client\native;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\error
;

final class tcp extends socket
{
	function __construct(host $host, $port)
	{
		parent::__construct($host, $port, 'tcp');
	}

	protected function newInstanceForHostAndPort(host $host, port $port)
	{
		return new self($host, $port);
	}
}
