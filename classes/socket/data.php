<?php

namespace estvoyage\net\endpoint\socket;

use
	estvoyage\net\world as net,
	estvoyage\net\world\socket
;

class data implements socket\data
{
	private
		$data
	;

	function __construct($data)
	{
		$this->data = $data;
	}

	function length(net\socket $socket, net\host $host, net\port $port, socket\data\lenght $length)
	{
		return $this;
	}
}
