<?php

namespace estvoyage\net\connection;

use
	estvoyage\net\world as net,
	estvoyage\net\connection,
	estvoyage\net\endpoint\socket
;

class udp extends connection
{
	function __construct(net\address $address)
	{
		parent::__construct($address, new socket\protocol\udp);
	}
}
