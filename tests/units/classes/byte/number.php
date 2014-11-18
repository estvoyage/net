<?php

namespace estvoyage\net\tests\units\byte;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units
;

class number extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\byte\number')
		;
	}
}
