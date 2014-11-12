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
			->implements('estvoyage\net\world\endpoint\address\component')
			->implements('estvoyage\net\world\endpoint\address')
		;
	}

	function testConnect()
	{
		$this
			->given(
				$this->calling($host = new net\host)->connect = $endpointConnectedToHost = new net\endpoint,
				$this->calling($port = new net\port)->connect = $endpointConnectedToPort = new net\endpoint,
				$endpoint = new net\endpoint
			)

			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->connect($endpoint))->isIdenticalTo($endpointConnectedToPort)
				->mock($host)->call('connect')->withIdenticalArguments($endpoint)->once
				->mock($port)->call('connect')->withIdenticalArguments($endpointConnectedToHost)->once
		;
	}
}
