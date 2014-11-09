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
				$driver = new net\socket\driver
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->writeOn($driver))->isTestedInstance
				->mock($driver)->call('writeData')->never

			->if(
				$this->calling($driver)->writeData = function($data, $dataRemaining) { $dataRemaining(''); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($driver))->isTestedInstance
				->mock($driver)->call('writeData')->withIdenticalArguments($data)->once

			->if(
				$this->calling($driver)->writeData[2] = function($data, $dataRemaining) { $dataRemaining(substr($data, 2)); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($driver))->isTestedInstance
				->mock($driver)
					->call('writeData')
						->withIdenticalArguments($data)->twice
						->withIdenticalArguments(substr($data, 2))->once

			->if(
				$this->calling($driver)->writeData->throw = new \exception($message = uniqid())
			)
			->then
				->exception(function() use ($driver) { $this->testedInstance->writeOn($driver); })
					->isInstanceOf('estvoyage\net\socket\data\exception')
					->hasMessage($message)
		;
	}
}
