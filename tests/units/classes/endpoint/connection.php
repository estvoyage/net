<?php

namespace estvoyage\net\tests\units\endpoint;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\endpoint,
	mock\estvoyage\net\world as net
;

class connection extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint')
		;
	}

	function test__construct()
	{
		$this
			->given(
				$this->calling($address = new net\endpoint\address)->connectTo = new net\endpoint\socket,
				$protocol = new net\endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($address, $protocol)
			)
			->then
				->mock($address)->call('connectTo')->withArguments(new endpoint\socket($protocol))->once
		;
	}

	function testConnect()
	{
		$this
			->given(
				$this->calling($address = new net\endpoint\address\component)->connectTo = $connectedConnection = new net\connection
			)
			->if(
				$this->newTestedInstance(new net\endpoint\address, new net\endpoint\socket\protocol)
			)
			->then
				->object($this->testedInstance->connect($address))->isIdenticalTo($connectedConnection)
				->mock($address)->call('connectTo')->withIdenticalArguments($this->testedInstance)->once
		;
	}

	function testWrite()
	{
		$this
			->given(
				$data = uniqid(),
				$callback = function($data) use (& $dataRemaining) { $dataRemaining = $data; },
				$this->calling($address = new net\endpoint\address)->connectTo = $connectedSocket = new net\endpoint\socket,
				$this->calling($protocol = new net\endpoint\socket\protocol)->write = function($data, $dataRemaining) { $dataRemaining(''); }
			)
			->if(
				$this->newTestedInstance($address, $protocol)
			)
			->then
				->object($this->testedInstance->write($data, $callback))->isTestedInstance
				->mock($connectedSocket)->call('write')->withIdenticalArguments($data, $callback)->once
		;
	}
}
