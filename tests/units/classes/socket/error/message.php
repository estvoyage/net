<?php

namespace estvoyage\net\tests\units\socket\error;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class message extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\string')
		;
	}
}
