<?php

namespace estvoyage\net\tests\units\socket\error;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class code extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\integer\unsigned')
		;
	}
}
