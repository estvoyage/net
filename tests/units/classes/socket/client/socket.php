<?php

namespace estvoyage\net\tests\units\socket\client;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class socket extends units\test
{
	function testClass()
	{
		$this->testedClass
			->isAbstract
			->implements('estvoyage\data\consumer')
		;
	}
}
