<?php

namespace estvoyage\net\tests\units\socket\data;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class byte extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\value\integer\unsigned')
		;
	}
}
