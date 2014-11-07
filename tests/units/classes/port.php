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

	function testOpenSocket()
	{
		$this
			->given(
				$socket = new net\socket,
				$host = uniqid()
			)
			->if(
				$this->calling($socket)->connectTo = $openedSocket = new net\socket,
				$this->newTestedInstance($port = rand(0, 65535))
			)
			->then
				->object($this->testedInstance->openSocket($socket, $host))->isIdenticalTo($openedSocket)
				->mock($socket)->call('connectTo')->withIdenticalArguments($host, $port)->once
		;
	}
}
