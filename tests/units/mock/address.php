<?php

namespace estvoyage\net;

class address
{
	public
		$host,
		$port
	;

	function __construct($host = null, $port = null)
	{
		$this->host = $host;
		$this->port = $port;
	}
}
