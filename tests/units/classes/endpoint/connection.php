<?php

namespace estvoyage\net\tests\units\endpoint;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
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

	function testConnect()
	{
		$this
			->given(
				$this->calling($address = new net\endpoint\address)->connectTo = $connectedConnection = new net\connection
			)
			->if(
				$this->newTestedInstance(new net\endpoint\address)
			)
			->then
				->object($this->testedInstance->connect($address))->isIdenticalTo($connectedConnection)
				->mock($address)->call('connectTo')->withIdenticalArguments($this->testedInstance)->once
		;
	}
}
