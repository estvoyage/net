<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class endpoint extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint')
		;
	}

	function testSend()
	{
		$this
			->given(
				$address = new net\endpoint\address,
				$socket = new net\socket,
				$data = new net\socket\data
			)
			->if(
				$this->newTestedInstance($address, $socket)
			)
			->then
				->object($this->testedInstance->send($data))->isTestedInstance
				->mock($address)->call('send')->withArguments($data, $socket)->once
		;
	}
}
