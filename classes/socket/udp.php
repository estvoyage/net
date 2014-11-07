<?php

namespace estvoyage\net\socket;

use
	estvoyage\net
;

class udp extends net\socket
{
	function __construct($host, $port)
	{
		parent::__construct(new driver\udp($host, $port));
	}
}
