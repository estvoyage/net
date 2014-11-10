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

	function testConnect()
	{
		$this
			->given(
				$this->calling($addressComponent = new net\endpoint\address\component)->connectTo = $endpointUsingComponent = new net\endpoint
			)
			->if(
				$this->newTestedInstance(new net\socket\protocol)
			)
			->then
				->object($this->testedInstance->connect($addressComponent))->isIdenticalTo($endpointUsingComponent)
				->mock($addressComponent)->call('connectTo')->withIdenticalArguments($this->testedInstance)->once
		;
	}

	function testConnectHost()
	{
		$this
			->given(
				$host = uniqid(),
				$this->calling($protocol = new net\socket\protocol)->connectHost = $protocolConnectedToHost = new net\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->connectHost($host))->isEqualTo($this->newTestedInstance($protocolConnectedToHost))
				->mock($protocol)->call('connectHost')->withIdenticalArguments($host)->once
		;
	}

	function testConnectPort()
	{
		$this
			->given(
				$port = uniqid(),
				$this->calling($protocol = new net\socket\protocol)->connectPort = $protocolConnectedToPort = new net\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->connectPort($port))->isEqualTo($this->newTestedInstance($protocolConnectedToPort))
				->mock($protocol)->call('connectPort')->withIdenticalArguments($port)->once
		;
	}

	function testWriteData()
	{
		$this
			->given(
				$data = uniqid(),
				$this->calling($protocol = new net\socket\protocol)->writeData = function($data, $callback) { $callback(''); },
				$callback = function($data) use (& $dataRemaining) { $dataRemaining = $data; }
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->writeData($data, $callback))->isTestedInstance
				->mock($protocol)->call('writeData')->withIdenticalArguments($data, $callback)->once
				->string($dataRemaining)->isEmpty
			->if(
				$this->calling($protocol)->writeData = function($data, $callback) { $callback(substr($data, 2)); }
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
				$protocol = new net\socket\protocol
			)
			->if(
				$this->newTestedInstance($protocol)
			)
			->then
				->object($this->testedInstance->write($data))->isTestedInstance
				->mock($data)->call('writeOn')->withIdenticalArguments($protocol)->once

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
				$this->calling($protocol = new net\socket\protocol)->shutdown = $protocolAfterShutdown = new net\socket\protocol
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
				$this->calling($protocol = new net\socket\protocol)->shutdownOnlyReading = $protocolAfterShutdown = new net\socket\protocol
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
				$this->calling($protocol = new net\socket\protocol)->shutdownOnlyWriting = $protocolAfterShutdown = new net\socket\protocol
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
				$this->calling($protocol = new net\socket\protocol)->disconnect = $protocolDisconnected = new net\socket\protocol
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
