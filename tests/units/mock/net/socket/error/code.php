<?php

namespace estvoyage\net\tests\units\mock\socket\error;

class code
{
	public
		$asInteger
	;

	function __construct($asInteger = 0)
	{
		$this->asInteger = $asInteger;
	}
}

@class_alias(__NAMESPACE__ . '\code', 'estvoyage\net\socket\error\code');
