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
			->implements('estvoyage\net\world\endpoint')
			->implements('estvoyage\net\world\socket')
		;
	}

	function testConnectHost()
	{
		$this
			->given(
				$host = uniqid(),
				$this->calling($driver = new net\socket\driver)->connectHost = $driverConnectedToHost = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->connectHost($host))->isEqualTo($this->newTestedInstance($driverConnectedToHost))
				->mock($driver)->call('connectHost')->withIdenticalArguments($host)->once
		;
	}

	function testConnectPort()
	{
		$this
			->given(
				$port = uniqid(),
				$this->calling($driver = new net\socket\driver)->connectPort = $driverConnectedToPort = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->connectPort($port))->isEqualTo($this->newTestedInstance($driverConnectedToPort))
				->mock($driver)->call('connectPort')->withIdenticalArguments($port)->once
		;
	}

	function testWriteData()
	{
		$this
			->given(
				$data = uniqid(),
				$this->calling($driver = new net\socket\driver)->writeData = function($data, $callback) { $callback(''); },
				$callback = function($data) use (& $dataRemaining) { $dataRemaining = $data; }
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->writeData($data, $callback))->isTestedInstance
				->mock($driver)->call('writeData')->withIdenticalArguments($data, $callback)->once
				->string($dataRemaining)->isEmpty
			->if(
				$this->calling($driver)->writeData = function($data, $callback) { $callback(substr($data, 2)); }
			)
			->then
				->object($this->testedInstance->writeData($data, $callback))->isTestedInstance
				->string($dataRemaining)->isEqualTo(substr($data, 2))
		;
	}

	function testWrite()
	{
		$this
			->given(
				$data = new net\socket\data,
				$driver = new net\socket\driver
			)
			->if(
				$this->newTestedInstance($driver)
			)
			->then
				->object($this->testedInstance->write($data))->isTestedInstance
				->mock($data)->call('writeOn')->withIdenticalArguments($driver)->once

			->if(
				$this->calling($data)->writeOn->throw = new \exception($message = uniqid())
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
