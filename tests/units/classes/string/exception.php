<?php

namespace estvoyage\net\tests\units\string;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units
;

class exception extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\string\exception')
			->implements('estvoyage\net\world\exception')
			->extends('exception')
		;
	}
}
