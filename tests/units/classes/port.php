<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class port extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\port')
		;
	}

	function test__construct()
	{
		$this
			->exception(function() use (& $port) { $this->newTestedInstance($port = rand(- PHP_INT_MAX, -1)); })
				->isInstanceOf('estvoyage\net\port\exception')
				->hasMessage('\'' . $port . '\' is not a valid port')

			->exception(function() use (& $port) { $this->newTestedInstance($port = rand(65536, PHP_INT_MAX)); })
				->isInstanceOf('estvoyage\net\port\exception')
				->hasMessage('\'' . $port . '\' is not a valid port')

			->exception(function() use (& $port) { $this->newTestedInstance($port = ''); })
				->isInstanceOf('estvoyage\net\port\exception')
				->hasMessage('\'' . $port . '\' is not a valid port')

			->exception(function() use (& $port) { $this->newTestedInstance($port = 1.1); })
				->isInstanceOf('estvoyage\net\port\exception')
				->hasMessage('\'' . $port . '\' is not a valid port')
		;
	}

	function test__toString()
	{
		$this
			->given(
				$port = rand(0, 65535)
			)
			->if(
				$this->newTestedInstance($port)
			)
			->then
				->castToString($this->testedInstance)->isEqualTo($port)
		;
	}
}
