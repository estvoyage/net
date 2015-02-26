<?php

namespace estvoyage\net\tests\units\socket\client\exception;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket\client
;

class logic extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('logicException')
			->implements('estvoyage\net\socket\client\exception')
		;
	}
}
