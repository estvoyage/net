<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net
;

class exception extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\exception')
			->extends('runtimeException')
		;
	}
}
