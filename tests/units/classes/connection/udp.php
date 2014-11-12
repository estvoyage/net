<?php

namespace estvoyage\net\tests\units\connection;

require __DIR__ . '/../../Runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\endpoint\socket,
	mock\estvoyage\net\world as net
;

class udp extends units\test
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
				$this->calling($address = new net\address)->connect = function($endpoint, $callback) { $callback(new net\endpoint\socket); }
			)
			->if(
				$this->newTestedInstance($address)
			)
			->then
				->mock($address)->call('connect')->withArguments(new socket(new socket\protocol\udp))->once
		;
	}
}
