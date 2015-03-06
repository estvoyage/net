<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\mtu as testedClass,
	estvoyage\data,
	mock\estvoyage\data as mockedData
;

class mtu extends test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\integer\unsigned')
			->isFinal
		;
	}

	function testConstructorWithInvalidValue()
	{
		$this->exception(function() { $this->newTestedInstance(rand(- PHP_INT_MAX, 67)); })
			->isInstanceOf('estvoyage\net\mtu\exception\domain')
			->hasMessage('MTU should be an integer greater than or equal to 68')
		;
	}
}
