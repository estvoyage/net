<?php

namespace estvoyage\net\tests\units\socket\driver;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world\socket,
	mock\estvoyage\net\world as net
;

class udp extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket\driver')
		;
	}

	function test__construct()
	{
		$this
			->given(
				$this->function->socket_create = uniqid(),
				$this->function->socket_last_error = $errorCode = uniqid(),
				$this->function->socket_strerror = $errorString = uniqid(),
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_DGRAM, SOL_UDP)->once

			->if(
				$this->function->socket_create = false
			)
			->then
				->exception(function() { $this->newTestedInstance(new net\host, new net\port); })
					->isInstanceOf('estvoyage\net\socket\driver\exception')
					->hasMessage($errorString)
				->function('socket_last_error')->wasCalledWithArguments(null)->once
				->function('socket_strerror')->wasCalledWithArguments($errorCode)->once
		;
	}

	function test__destruct()
	{
		$this
			->given(
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance(new net\host, new net\port)->__destruct()
			)
			->then
				->function('socket_close')->wasCalledWithArguments($resource)->once
		;
	}

	function test__clone()
	{
		$this
			->given(
				$this->function->socket_create[1] = $resource = uniqid(),
				$this->function->socket_create[2] = $otherResource = uniqid(),
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->when(function() { clone $this->testedInstance; })
			->then
				->function('socket_close')->wasCalledWithArguments($resource)->never
				->function('socket_close')->wasCalledWithArguments($otherResource)->once
		;
	}

	function testConnectTo()
	{
		$this
			->given(
				$this->calling($host1 = new net\host)->__toString = $host1Value = uniqid(),
				$this->calling($port1 = new net\port)->__toString = $port1Value = uniqid(),

				$this->calling($host2 = new net\host)->__toString = $host2Value = uniqid(),
				$this->calling($port2 = new net\port)->__toString = $port2Value = uniqid(),

				$this->function->socket_create = uniqid(),
				$this->function->socket_close->doesNothing
			)

			->if(
				$this->newTestedInstance($host1, $port1)
			)
			->then
				->object($this->testedInstance->connectTo($host1, $port1))->isTestedInstance
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_DGRAM, SOL_UDP)->once

				->object($this->testedInstance->connectTo($host2, $port1))->isEqualTo($this->newTestedInstance($host2, $port1))
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_DGRAM, SOL_UDP)->thrice

				->object($this->testedInstance->connectTo($host1, $port2))->isEqualTo($this->newTestedInstance($host1, $port2))
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_DGRAM, SOL_UDP)->{5}

				->object($this->testedInstance->connectTo($host2, $port2))->isEqualTo($this->newTestedInstance($host2, $port2))
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_DGRAM, SOL_UDP)->{7}
		;
	}

	function testWrite()
	{
		$this
			->given(
				$this->calling($host = new net\host)->__toString = $hostValue = uniqid(),
				$this->calling($port = new net\port)->__toString = $portValue = uniqid(),

				$data = new socket\data,
				$this->calling($data)->__toString = $dataContents = uniqid(),
				$this->calling($data)->remove = $dataWithRemovedBytes = new socket\data,

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errorCode = uniqid(),
				$this->function->socket_strerror = $errorString = uniqid()
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->write($data))->isIdenticalTo($dataWithRemovedBytes)
				->function('socket_sendto')->wasCalledWithArguments($resource, $dataContents, strlen($dataContents), 0, $host, $port)->once
				->mock($data)->call('remove')->withIdenticalArguments(strlen($dataContents))->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->write($data))->isIdenticalTo($dataWithRemovedBytes)
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $host, $port)->twice
				->mock($data)->call('remove')->withIdenticalArguments(2)->once

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->write($data); })
					->isInstanceOf('estvoyage\net\socket\driver\exception')
					->hasMessage($errorString)
				->function('socket_last_error')->wasCalledWithArguments($resource)->once
				->function('socket_strerror')->wasCalledWithArguments($errorCode)->once
		;
	}

	function testShutdown()
	{
		$this
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->object($this->testedInstance->shutdown())->isTestedInstance
		;
	}

	function testShutdownOnlyReading()
	{
		$this
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->object($this->testedInstance->shutdownOnlyReading())->isTestedInstance
		;
	}

	function testShutdownOnlyWriting()
	{
		$this
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->object($this->testedInstance->shutdownOnlyWriting())->isTestedInstance
		;
	}

	function testDisconnect()
	{
		$this
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->object($this->testedInstance->disconnect())->isTestedInstance
		;
	}
}
