<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class data extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket\data')
		;
	}

	function testWriteOn()
	{
		$this
			->given(
				$data = uniqid(),
				$protocol = new net\socket\protocol
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->writeOn($protocol))->isTestedInstance
				->mock($protocol)->call('writeData')->never

			->if(
				$this->calling($protocol)->writeData = function($data, $dataRemaining) { $dataRemaining(''); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($protocol))->isTestedInstance
				->mock($protocol)->call('writeData')->withIdenticalArguments($data)->once

			->if(
				$this->calling($protocol)->writeData[2] = function($data, $dataRemaining) { $dataRemaining(substr($data, 2)); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($protocol))->isTestedInstance
				->mock($protocol)
					->call('writeData')
						->withIdenticalArguments($data)->twice
						->withIdenticalArguments(substr($data, 2))->once

			->if(
				$this->calling($protocol)->writeData->throw = new \exception($message = uniqid())
			)
			->then
				->exception(function() use ($protocol) { $this->testedInstance->writeOn($protocol); })
					->isInstanceOf('estvoyage\net\socket\data\exception')
					->hasMessage($message)
		;
	}
}
