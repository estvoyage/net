<?php

namespace estvoyage\net\socket;

class data
{
	public
		$value
	;

	function __construct($value = '')
	{
		$this->value = $value;
	}

	function __toString()
	{
		return (string) $this->value;
	}
}
