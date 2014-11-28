<?php

namespace estvoyage\net\tests\units\mock\socket;

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

@class_alias(__NAMESPACE__ . '\data', 'estvoyage\net\socket\data');
