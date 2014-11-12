<?php

namespace estvoyage\net\tests\units\endpoint;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\endpoint\socket\data,
	mock\estvoyage\net\world\endpoint
;

class socket extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint')
			->implements('estvoyage\net\world\endpoint\socket')
		;
	}

	function testConnectHost()
	{
		$this
			->given(
				$host = uniqid(),
				$this->calling($protocol = new endpoint\socket\protocol)->connectHost = $protocolConnectedToHost = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->connectHost($host))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance($protocolConnectedToHost))
				->mock($protocol)->call('connectHost')->withIdenticalArguments($host)->once
		;
	}

	function testConnectPort()
	{
		$this
			->given(
				$port = uniqid(),
				$this->calling($protocol = new endpoint\socket\protocol)->connectPort = $protocolConnectedToPort = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->connectPort($port))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance($protocolConnectedToPort))
				->mock($protocol)->call('connectPort')->withIdenticalArguments($port)->once
		;
	}

	function testWrite()
	{
		$this
			->given(
				$data = uniqid(),
				$this->calling($protocol = new endpoint\socket\protocol)->write = function($data, $callback) { $callback(''); },
				$callback = function($data) use (& $dataRemaining) { $dataRemaining = $data; }
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->write($data, $callback))->isTestedInstance
				->mock($protocol)->call('write')->withIdenticalArguments($data, $callback)->once
				->string($dataRemaining)->isEmpty
			->if(
				$this->calling($protocol)->write = function($data, $callback) { $callback(substr($data, 2)); }
			)
			->then
				->object($this->testedInstance->write($data, $callback))->isTestedInstance
				->string($dataRemaining)->isEqualTo(substr($data, 2))
		;
	}

	function testShutdown()
	{
		$this
			->given(
				$this->calling($protocol = new endpoint\socket\protocol)->shutdown = $protocolAfterShutdown = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->shutdown())->isEqualTo($this->newTestedInstance($protocolAfterShutdown))
				->mock($protocol)->call('shutdown')->once
		;
	}

	function testShutdownOnlyReading()
	{
		$this
			->given(
				$this->calling($protocol = new endpoint\socket\protocol)->shutdownOnlyReading = $protocolAfterShutdown = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->shutdownOnlyReading())->isEqualTo($this->newTestedInstance($protocolAfterShutdown))
				->mock($protocol)->call('shutdownOnlyReading')->once
		;
	}

	function testShutdownOnlyWriting()
	{
		$this
			->given(
				$this->calling($protocol = new endpoint\socket\protocol)->shutdownOnlyWriting = $protocolAfterShutdown = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->shutdownOnlyWriting())->isEqualTo($this->newTestedInstance($protocolAfterShutdown))
				->mock($protocol)->call('shutdownOnlyWriting')->once
		;
	}

	function testDisconnect()
	{
		$this
			->given(
				$this->calling($protocol = new endpoint\socket\protocol)->disconnect = $protocolDisconnected = new endpoint\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->disconnect())->isEqualTo($this->newTestedInstance($protocolDisconnected))
				->mock($protocol)->call('disconnect')->once
		;
	}
}
