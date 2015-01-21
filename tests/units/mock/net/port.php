<?php

namespace estvoyage\net;

class port
{
	public
		$asInteger
	;

	function __construct($value = null)
	{
		$this->asInteger = $value ?: rand(1, 65535);
	}
}
