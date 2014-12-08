<?php

namespace estvoyage\net;

use
	estvoyage\value\world as value,
	estvoyage\net\host,
	estvoyage\net\port
;

final class address
{
	use value\immutable;

	function __construct(host $host, port $port)
	{
		$this->init([ 'host' => $host, 'port' => $port ]);
	}
}
