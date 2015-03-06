<?php

namespace estvoyage\net\tests\units\mtu\exception;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class domain extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('domainException')
			->implements('estvoyage\net\mtu\exception')
		;
	}
}
