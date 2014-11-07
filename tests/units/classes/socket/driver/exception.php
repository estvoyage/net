<?php

namespace estvoyage\net\tests\units\socket\driver;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class exception extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket\driver\exception')
			->implements('estvoyage\net\world\socket\exception')
			->implements('estvoyage\net\world\exception')
			->extends('exception')
		;
	}
}
