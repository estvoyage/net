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
				->mock($driver)->call('write')->never

			->if(
				$this->calling($driver)->write = function($data) { return strlen($data); },
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($driver))->isTestedInstance
				->mock($driver)->call('write')->withIdenticalArguments($data)->once

			->if(
				$this->calling($driver)->write[2] = 2,
				$this->calling($driver)->write[3] = strlen($data - 2),
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($driver))->isTestedInstance
				->mock($driver)
					->call('write')
						->withIdenticalArguments($data)->twice
						->withIdenticalArguments(substr($data, 2))->once

			->if(
				$this->calling($driver)->write->throw = new \exception($message = uniqid())
			)
			->then
				->exception(function() use ($driver) { $this->testedInstance->writeOn($driver); })
					->isInstanceOf('estvoyage\net\socket\data\exception')
					->hasMessage($message)
		;
	}
}
