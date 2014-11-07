<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket\data,
	mock\estvoyage\net\world as net
;

class socket extends units\test
{
	function testWrite()
	{
		$this
			->given(
				$data = uniqid(),
				$driver = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->write($data))->isTestedInstance
				->mock($driver)->call('write')->withArguments(new data($data))->once

			->if(
				$this->calling($driver)->write->throw = new \exception($message = uniqid())
			)
			->then
				->exception(function() { $this->testedInstance->write(uniqid()); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasMessage($message)
		;
	}

	function testConnectTo()
	{
		$this
			->given(
				$host = uniqid(),
				$port = uniqid(),
				$this->calling($driver = new net\socket\driver)->connectTo = $driverUpdated = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->connectTo($host, $port))->isEqualTo($this->newTestedInstance($driverUpdated))
				->mock($driver)->call('connectTo')->withIdenticalArguments($host, $port)->once
		;
	}
}
