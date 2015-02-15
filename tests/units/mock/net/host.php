<?php

namespace estvoyage\net;

class host
{
	private
		$asString
	;

	function __construct($value = '')
	{
		$this->asString = (string) $value ?: uniqid();
	}

	function __toString()
	{
		return $this->asString;
	}
}
