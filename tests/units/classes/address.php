<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class address extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\address')
		;
	}

	function testconnectSocket()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$socket = new net\socket
			)

			->if(
				$this->calling($socket)->connectTo = $connectedSocket = new net\socket,
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->connectSocket($socket))->isIdenticalTo($connectedSocket)
				->mock($socket)->call('connectTo')->withIdenticalArguments($host, $port)->once
		;
	}
}
