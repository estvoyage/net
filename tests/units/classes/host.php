<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units
;

class host extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\string')
			->implements('estvoyage\net\world\host')
		;
	}

	function test__constructWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('Value can not be converted to string')
		;
	}

	function test__constructWithNotWellFormatedValue($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('Host \'' . $value . '\' is invalid')
		;
	}

	protected function test__constructWithInvalidValueDataProvider()
	{
		return [
			new \stdclass
		];
	}

	protected function test__constructWithNotWellFormatedValueDataProvider()
	{
		// See http://en.wikipedia.org/wiki/Hostname

		return [
			'',
			'-',
			'a b',
			'a,b',
			str_repeat('a', 64),
			str_repeat('a', 63) . '.' . str_repeat('b', 63) . '.' . str_repeat('c', 63) . '.' . str_repeat('d', 64)
		];
	}
}
