<?php

namespace estvoyage\net\tests\units\mtu;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units
;

class overflow extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\exception')
			->extends('overflowException')
		;
	}
}
