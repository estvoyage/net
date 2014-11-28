<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

class host extends test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\string')
		;
	}
}
