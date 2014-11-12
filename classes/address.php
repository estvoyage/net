<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class address implements net\endpoint\address
{
	private
		$host,
		$port
	;

	function __construct(net\host $host, net\port $port)
	{
		$this->host = $host;
		$this->port = $port;
	}

	function connect(net\endpoint $endpoint, callable $callback)
	{
		$this->host
			->connect($endpoint, function($endpoint) use ($callback) {
					$this->port->connect($endpoint, $callback);
				}
			)
		;

		return $this;
	}
}
