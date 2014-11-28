<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units
;

class data extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\string')
		;
	}
}
