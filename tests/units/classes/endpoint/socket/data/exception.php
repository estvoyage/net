<?php

namespace estvoyage\net\tests\units\endpoint\socket\data;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units
;

class exception extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint\socket\data\exception')
			->implements('estvoyage\net\world\exception')
			->extends('estvoyage\net\exception')
		;
	}
}
