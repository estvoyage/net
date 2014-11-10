<?php

namespace estvoyage\net\endpoint\socket;

use
	estvoyage\net\endpoint
;

class udp extends endpoint\socket
{
	function __construct($host, $port)
	{
		parent::__construct(new protocol\udp($host, $port));
	}
}
