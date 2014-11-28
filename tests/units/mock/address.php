<?php

namespace estvoyage\net\tests\units\mock;

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

@class_alias(__NAMESPACE__ . '\address', 'estvoyage\net\address');
