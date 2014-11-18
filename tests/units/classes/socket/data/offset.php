<?php

namespace estvoyage\net\tests\units\socket\data;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class offset extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\string')
			->implements('estvoyage\net\world\socket\data\offset')
		;
	}

	function test__constructWithValueNotUsableAsOffset($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\socket\data\offset\exception')
				->hasMessage('Value of type \'' . gettype($value) . '\' can not be used as offset')
		;
	}

	function test__constructWithValueNotInteger($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\socket\data\offset\exception')
				->hasMessage('Value \'' . $value . '\' is not an integer')
		;
	}

	function test__constructWithNegativeInteger($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\socket\data\offset\exception')
				->hasMessage('Value \'' . $value . '\' is not greater than 0')
		;
	}

	function test__toString()
	{
		$this
			->given(
				$value = rand(0, PHP_INT_MAX)
			)
			->if(
				$this->newTestedInstance($value)
			)
			->then
				->castToString($this->testedInstance)->isEqualTo((string) $value)
		;
	}

	protected function test__constructWithValueNotUsableAsOffsetDataProvider()
	{
		return [
			new \stdclass,
		];
	}

	protected function test__constructWithValueNotIntegerDataProvider()
	{
		return [
			uniqid(),
			'',
			null,
			false,
			true,
			rand(1, 100) / 100
		];
	}

	protected function test__constructWithNegativeIntegerDataProvider()
	{
		return [
			rand(- PHP_INT_MAX, -1)
		];
	}
}
