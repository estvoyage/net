<?php

namespace estvoyage\net\tests\units\endpoint;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class address extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint\address')
		;
	}

	function testSend()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$data = new net\socket\data,
				$socket = new net\socket
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->send($data, $socket))->isTestedInstance
				->mock($socket)->call('write')->withIdenticalArguments($data, $host, $port)->once
		;
	}
}
