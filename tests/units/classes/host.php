<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class host extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\host')
		;
	}

	function test__construct()
	{
		$this
			->exception(function() { $this->newTestedInstance(''); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('\'\' is not a valid host')

			->exception(function() { $this->newTestedInstance('-'); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('\'-\' is not a valid host')

			->exception(function() { $this->newTestedInstance('a b'); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('\'a b\' is not a valid host')

			->exception(function() { $this->newTestedInstance('a,b'); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('\'a,b\' is not a valid host')

			->exception(function() use (& $host) { $this->newTestedInstance($host = str_repeat('a', 64)); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('\'' . $host . '\' is not a valid host')

			->exception(function() use (& $host) { $this->newTestedInstance($host = str_repeat('a', 63) . '.' . str_repeat('b', 63) . '.' . str_repeat('c', 63) . '.' . str_repeat('d', 64)); })
				->isInstanceOf('estvoyage\net\host\exception')
				->hasMessage('\'' . $host . '\' is not a valid host')
		;
	}

	function testConnectTo()
	{
		$this
			->given(
				$host = 'foo.bar',
				$this->calling($endpoint = new net\endpoint)->connectHost = $endpointConnectedToHost = new net\endpoint
			)
			->if(
				$this->newTestedInstance($host)
			)
			->then
				->object($this->testedInstance->connectTo($endpoint))->isIdenticalTo($endpointConnectedToHost)
		;
	}
}