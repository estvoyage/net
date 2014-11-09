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
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket')
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
				->exception(function() use ($data) { $this->testedInstance->write($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasMessage($message)
		;
	}

	function testShutdown()
	{
		$this
			->given(
				$this->calling($driver = new net\socket\driver)->shutdown = $driverAfterShutdown = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->shutdown())->isEqualTo($this->newTestedInstance($driverAfterShutdown))
				->mock($driver)->call('shutdown')->once
		;
	}

	function testShutdownOnlyReading()
	{
		$this
			->given(
				$this->calling($driver = new net\socket\driver)->shutdownOnlyReading = $driverAfterShutdown = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->shutdownOnlyReading())->isEqualTo($this->newTestedInstance($driverAfterShutdown))
				->mock($driver)->call('shutdownOnlyReading')->once
		;
	}

	function testShutdownOnlyWriting()
	{
		$this
			->given(
				$this->calling($driver = new net\socket\driver)->shutdownOnlyWriting = $driverAfterShutdown = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->shutdownOnlyWriting())->isEqualTo($this->newTestedInstance($driverAfterShutdown))
				->mock($driver)->call('shutdownOnlyWriting')->once
		;
	}

	function testDisconnect()
	{
		$this
			->given(
				$this->calling($driver = new net\socket\driver)->disconnect = $driverDisconnected = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->disconnect())->isEqualTo($this->newTestedInstance($driverDisconnected))
				->mock($driver)->call('disconnect')->once
		;
	}
}
