<?php

namespace estvoyage\net\tests\units\mock\socket\error;

class message
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

@class_alias(__NAMESPACE__ . '\message', 'estvoyage\net\socket\error\message');
