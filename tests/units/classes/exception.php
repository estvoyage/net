<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

class exception extends test
{
	function testClass()
	{
		$this->testedClass
			->extends('exception')
		;
	}
}
