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
			->implements('estvoyage\net\world\address\component')
			->implements('estvoyage\net\world\address')
		;
	}

	function testConnect()
	{
		$this
			->given(
				$this->calling($host = new net\host)->connect = function($endpoint, $callback) use (& $endpointAfterHostConnect) { $callback($endpointAfterHostConnect = new net\endpoint); },
				$this->calling($port = new net\port)->connect = function($endpoint, $callback) use (& $endpointAfterPortConnect) { $callback($endpointAfterPortConnect = new net\endpoint); },
				$callback = function($endpoint) use (& $endpointConnectedToHostAndPort) { $endpointConnectedToHostAndPort = $endpoint; },
				$endpoint = new net\endpoint
			)

			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->connect($endpoint, $callback))->isTestedInstance
				->mock($host)->call('connect')->withIdenticalArguments($endpoint)->once
				->mock($port)->call('connect')->withIdenticalArguments($endpointAfterHostConnect)->once
				->object($endpointConnectedToHostAndPort)->isIdenticalTo($endpointAfterPortConnect)
		;
	}
}
