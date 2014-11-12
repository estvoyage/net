<?php

namespace estvoyage\net\tests\units\host;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class localhost extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\host')
		;
	}

	function testConnect()
	{
		$this
			->given(
				$this->calling($endpoint = new net\endpoint)->connectHost = $endpointAfterConnectHost = new net\endpoint,
				$callback = function($endpoint) use (& $endpointConnectedToHost) { $endpointConnectedToHost = $endpoint; }
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->connect($endpoint, $callback))->isTestedInstance
				->mock($endpoint)->call('connectHost')->withIdenticalArguments('127.0.0.1')->once
				->object($endpointConnectedToHost)->isIdenticalTo($endpointAfterConnectHost)
		;
	}
}
