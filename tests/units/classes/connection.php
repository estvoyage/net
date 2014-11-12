<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

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
			->implements('estvoyage\net\world\connection')
		;
	}

	function test__construct()
	{
		$this
			->given(
				$this->calling($address = new net\address)->connect = function($endpoint, $callback) { $callback(new net\endpoint\socket); },
				$protocol = new net\endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($address, $protocol)
			)
			->then
				->mock($address)->call('connect')->withArguments(new endpoint\socket($protocol))->once
		;
	}

	function testWrite()
	{
		$this
			->given(
				$data = uniqid(),
				$callback = function($data) use (& $dataRemaining) { $dataRemaining = $data; },
				$this->calling($address = new net\address)->connect = function($endpoint, $callback) use (& $connectedSocket) { $callback($connectedSocket = new net\endpoint\socket); },
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
