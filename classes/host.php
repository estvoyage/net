<?php

namespace estvoyage\net;

use
	estvoyage\net\value,
	estvoyage\net\world as net
;

class host implements net\host
{
	private
		$host
	;

	function __construct($host)
	{
		(new host\validator)
			->validate(
				$host,
				function($host) { $this->host = $host; },
				function($host) { throw new host\exception('\'' . $host . '\' is not a valid host'); }
			)
		;
	}

	function connect(net\endpoint $endpoint, callable $callback)
	{
		$callback($endpoint->connectHost($this->host));

		return $this;
	}
}
