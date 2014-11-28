<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\port as testedClass
;

class port extends test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\integer\unsigned')
		;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($value)
	{
		$this->exception(function() use ($value) { $this->newTestedInstance($value); })
			->isInstanceOf('domainException')
			->hasMessage('Port should be an integer greater than or equal to 0 and less than 65536')
		;
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testValidateWithInvalidValue($value)
	{
		$this->boolean(testedClass::validate($value))->isFalse;
	}

	protected function invalidValueProvider()
	{
		return [
			null,
			true,
			false,
			'',
			uniqid(),
			- rand(1, PHP_INT_MAX),
			rand(65536, PHP_INT_MAX),
			(float) rand(-PHP_INT_MAX, PHP_INT_MAX),
			[ [] ],
			new \stdclass
		];
	}
}
