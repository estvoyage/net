<?php

namespace estvoyage\net\socket\data;

class byte
{
	public
		$asInteger
	;

	function __construct($value = 0)
	{
		$this->asInteger = $value;
	}
}
