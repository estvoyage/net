<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units
;

class string extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\string')
		;
	}

	function test__constructWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\string\exception')
				->hasMessage('Value can not be converted to string')
		;
	}

	function test__toString($value)
	{
		$this
			->castToString($this->newTestedInstance($value))->isEqualTo((string) $value)
		;
	}

	protected function test__constructWithInvalidValueDataProvider()
	{
		return [
			new \stdclass
		];
	}

	protected function test__toStringDataProvider()
	{
		return [
			'',
			null,
			true,
			false,
			uniqid(),
			rand(- PHP_INT_MAX, PHP_INT_MAX),
			(float) rand(- PHP_INT_MAX, PHP_INT_MAX),
		];
	}
}
