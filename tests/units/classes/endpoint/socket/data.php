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
				$protocol = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->writeOn($protocol))->isTestedInstance
				->mock($protocol)->call('write')->never

			->if(
				$this->calling($protocol)->write = function($data, $dataRemaining) { $dataRemaining(''); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($protocol))->isTestedInstance
				->mock($protocol)->call('write')->withIdenticalArguments($data)->once

			->if(
				$this->calling($protocol)->write[2] = function($data, $dataRemaining) { $dataRemaining(substr($data, 2)); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($protocol))->isTestedInstance
				->mock($protocol)
					->call('write')
						->withIdenticalArguments($data)->twice
						->withIdenticalArguments(substr($data, 2))->once

			->if(
				$this->calling($protocol)->write->throw = new \exception($message = uniqid())
			)
			->then
				->exception(function() use ($protocol) { $this->testedInstance->writeOn($protocol); })
					->isInstanceOf('estvoyage\net\endpoint\socket\data\exception')
					->hasMessage($message)
		;
	}
}
