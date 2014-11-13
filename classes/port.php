<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class port implements net\port
{
	private
		$port
	;

	function __construct($port)
	{
		(new port\validator())
			->validate(
				$port,
				function($port) { $this->port = $port; },
				function($port) { throw new port\exception('\'' . $port . '\' is not a valid port'); }
			)
		;
	}

	function connect(net\endpoint $endpoint, callable $callback)
	{
		$callback($endpoint->connectPort($this->port));

		return $this;
	}
}
