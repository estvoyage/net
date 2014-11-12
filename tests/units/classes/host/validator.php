<?php

namespace estvoyage\net\tests\units\host;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units
;

// See http://en.wikipedia.org/wiki/Hostname

class validator extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\host\validator')
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
			'-',
			'a b',
			'a,b',
			str_repeat('a', 64),
			str_repeat('a', 63) . '.' . str_repeat('b', 63) . '.' . str_repeat('c', 63) . '.' . str_repeat('d', 64)
		];
	}

	protected function testValidateWithValidValueDataProvider()
	{
		return [
			'127.0.0.1',
			'locahost',
			'jupiter',
			'jupiter.example',
			'jupiter.example.net',
		];
	}
}
