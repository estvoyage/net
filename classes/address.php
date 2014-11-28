<?php

namespace estvoyage\net;

use
	estvoyage\value,
	estvoyage\net\host,
	estvoyage\net\port
;

final class address extends value\generic
{
	use immutable;

	function __construct(host $host, port $port)
	{
		parent::__construct([ 'host' => $host, 'port' => $port ]);
	}
}
