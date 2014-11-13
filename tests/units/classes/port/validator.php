<?php

namespace estvoyage\net\tests\units\port;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units
;

class validator extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\port\validator')
		;
	}

	function testValidateWithInvalidValue($value)
	{
		$this
			->given(
				$ko = function($value) use (& $invalidValue) { $invalidValue = $value; }
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->validate($value, function() {}))->isTestedInstance

				->object($this->testedInstance->validate($value, function() {}, $ko))->isTestedInstance
				->variable($invalidValue)->isIdenticalTo($value)
		;
	}

	function testValidateWithValidValue($value)
	{
		$this
			->given(
				$ok = function($value) use (& $validValue) { $validValue = $value; }
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->validate($value, $ok))->isTestedInstance
				->variable($validValue)->isIdenticalTo($value)
		;
	}

	protected function testValidateWithInvalidValueDataProvider()
	{
		return [
			'',
			null,
			uniqid(),
			- rand(1, PHP_INT_MAX),
			rand(65536, PHP_INT_MAX),
			rand(1, 100) / 100
		];
	}

	protected function testValidateWithValidValueDataProvider()
	{
		return [
			0,
			'0',
			rand(1, 65535),
			(string) rand(1, 65535)
		];
	}
}
