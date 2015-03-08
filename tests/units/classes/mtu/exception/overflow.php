<?php

namespace estvoyage\net\tests\units\mtu\exception;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class overflow extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('overflowException')
			->implements('estvoyage\net\mtu\exception')
		;
	}
}
