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

	function test__toString()
	{
		$this
			->given(
				$data = uniqid()
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->castToString($this->testedInstance)->isEmpty

			->if(
				$this->newTestedInstance($data)
			)
			->then
				->castToString($this->testedInstance)->isEqualTo($data)
		;
	}

	function testRemove()
	{
		$this
			->given(
				$data = 'abcdefgh'
			)
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->remove(0))->isTestedInstance
				->object($this->testedInstance->remove(rand(1, PHP_INT_MAX)))->isTestedInstance
				->object($this->testedInstance->remove(- rand(1, PHP_INT_MAX)))->isTestedInstance

			->if(
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->remove(0))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance($data))
				->object($this->testedInstance->remove(1))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance('bcdefgh'))
				->object($this->testedInstance->remove(-1))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance('h'))
				->object($this->testedInstance->remove(8))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance)
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
				$this->calling($driver)->write = $this->newTestedInstance,
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($driver))->isTestedInstance
				->mock($driver)->call('write')->withIdenticalArguments($this->testedInstance)->once

			->if(
				$this->calling($driver)->write[2] = $dataMinus2Bytes = $this->testedInstance->remove(2),
				$this->calling($driver)->write[3] = $this->testedInstance->remove(strlen($data - 2)),
				$this->newTestedInstance($data)
			)
			->then
				->object($this->testedInstance->writeOn($driver))->isTestedInstance
				->mock($driver)
					->call('write')
						->withIdenticalArguments($this->testedInstance)->once
						->withIdenticalArguments($dataMinus2Bytes)->once

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
