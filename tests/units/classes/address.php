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

	function testConnectTo()
	{
		$this
			->given(
				$this->calling($host = new net\host)->connectTo = $endpointConnectedToHost = new net\endpoint,
				$this->calling($port = new net\port)->connectTo = $endpointConnectedToPort = new net\endpoint,
				$endpoint = new net\endpoint
			)

			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->connectTo($endpoint))->isIdenticalTo($endpointConnectedToPort)
				->mock($host)->call('connectTo')->withIdenticalArguments($endpoint)->once
				->mock($port)->call('connectTo')->withIdenticalArguments($endpointConnectedToHost)->once
		;
	}
}
