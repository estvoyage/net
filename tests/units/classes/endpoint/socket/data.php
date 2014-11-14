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
				$data = uniqid(),
				$endpoint = new endpoint\socket
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->writeOn($endpoint))->isTestedInstance
				->mock($endpoint)->call('write')->never

			->if(
				$this->calling($endpoint)->write = function($data, $dataRemaining) { $dataRemaining(''); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($endpoint))->isTestedInstance
				->mock($endpoint)->call('write')->withIdenticalArguments($data)->once

			->if(
				$this->calling($endpoint)->write[2] = function($data, $dataRemaining) { $dataRemaining(substr($data, 2)); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($endpoint))->isTestedInstance
				->mock($endpoint)
					->call('write')
						->withIdenticalArguments($data)->twice
						->withIdenticalArguments(substr($data, 2))->once

			->if(
				$this->calling($endpoint)->write->throw = new \exception($message = uniqid())
			)
			->then
				->exception(function() use ($endpoint) { $this->testedInstance->writeOn($endpoint); })
					->isInstanceOf('estvoyage\net\endpoint\socket\data\exception')
					->hasMessage($message)
		;
	}
}
