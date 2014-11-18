<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units
;

class port extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\string')
			->implements('estvoyage\net\world\port')
		;
	}

	function test__constructWithInvalidValue($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\port\exception')
				->hasMessage('Value can not be converted to string')
		;
	}

	function test__constructWithNotWellFormatedValue($value)
	{
		$this
			->exception(function() use ($value) { $this->newTestedInstance($value); })
				->isInstanceOf('estvoyage\net\port\exception')
				->hasMessage('Port \'' . $value . '\' is invalid')
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
			null,
			uniqid(),
			- rand(1, PHP_INT_MAX),
			rand(65536, PHP_INT_MAX),
			rand(1, 100) / 100
		];
	}
}
