<?php

namespace estvoyage\net\tests\units\socket\data\offset;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units
;

class exception extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket\data\offset\exception')
			->implements('estvoyage\net\world\exception')
			->extends('exception')
		;
	}
}
