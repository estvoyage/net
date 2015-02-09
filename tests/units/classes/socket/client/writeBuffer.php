<?php

namespace estvoyage\net\tests\units\socket\client;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	mock\estvoyage\net\world as mock
;

abstract class writeBuffer extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
		;
	}
}
