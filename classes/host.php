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
		if (! preg_match('/^[0-9a-z][0-9a-z-]{0,62}(?:\.[0-9a-z-]{1,63}){0,3}$/i', $host))
		{
			throw new host\exception('\'' . $host . '\' is not a valid host');
		}

		$this->host = $host;
	}

	function connectTo(net\endpoint $endpoint)
	{
		return $endpoint->connectHost($this->host);
	}
}
