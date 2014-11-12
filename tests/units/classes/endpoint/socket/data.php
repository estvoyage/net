<?php

namespace estvoyage\net\tests\units\endpoint\socket;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world\endpoint
;

class data extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint\data')
			->implements('estvoyage\net\world\endpoint\socket\data')
		;
	}

	function testWriteOn()
	{
		$this
			->given(
				$host = uniqid(),
				$port = uniqid(),
				$data = uniqid(),
				$protocol = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->writeOn($protocol, $host, $port))->isTestedInstance
				->mock($protocol)->call('write')->never

			->if(
				$this->calling($protocol)->write = function($data, $host, $port, $dataRemaining) { $dataRemaining(''); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($protocol, $host, $port))->isTestedInstance
				->mock($protocol)->call('write')->withIdenticalArguments($data, $host, $port)->once

			->if(
				$this->calling($protocol)->write[2] = function($data, $host, $port, $dataRemaining) { $dataRemaining(substr($data, 2)); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($protocol, $host, $port))->isTestedInstance
				->mock($protocol)
					->call('write')
						->withIdenticalArguments($data, $host, $port)->twice
						->withIdenticalArguments(substr($data, 2))->once

			->if(
				$this->calling($protocol)->write->throw = new \exception($message = uniqid())
			)
			->then
				->exception(function() use ($protocol, $host, $port) { $this->testedInstance->writeOn($protocol, $host, $port); })
					->isInstanceOf('estvoyage\net\endpoint\socket\data\exception')
					->hasMessage($message)
		;
	}
}
