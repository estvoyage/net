<?php

namespace estvoyage\net\socket;

class data
{
	public
		$asString
	;

	function __construct($asString = '')
	{
		$this->asString = $asString;
	}

	function __toString()
	{
		return $this->asString;
	}
}
