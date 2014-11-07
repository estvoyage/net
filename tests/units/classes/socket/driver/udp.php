<?php

namespace estvoyage\net\tests\units\socket\driver;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
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
				$host = uniqid(),
				$port = uniqid(),
				$this->function->socket_create = uniqid(),
				$this->function->socket_last_error = $errorCode = uniqid(),
				$this->function->socket_strerror = $errorString = uniqid(),
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_DGRAM, SOL_UDP)->once

			->if(
				$this->function->socket_create = false
			)
			->then
				->exception(function() { $this->newTestedInstance(uniqid(), uniqid()); })
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
				$this->newTestedInstance(uniqid(), uniqid())->__destruct()
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
				$this->newTestedInstance(uniqid(), uniqid())
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
				$host = uniqid(),
				$port = uniqid(),
				$this->function->socket_create = uniqid(),
				$this->function->socket_close->doesNothing
			)

			->if(
				$this->newTestedInstance(uniqid(), uniqid())
			)
			->then
				->object($this->testedInstance->connectTo($host, $port))->isEqualTo($this->newTestedInstance($host, $port))
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_DGRAM, SOL_UDP)->thrice
		;
	}

	function testWrite()
	{
		$this
			->given(
				$host = uniqid(),
				$port = uniqid(),
				$data = uniqid(),
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
				->integer($this->testedInstance->write($data))->isEqualTo(strlen($data))
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $host, $port)->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->integer($this->testedInstance->write($data))->isEqualTo(2)
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $host, $port)->twice

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
				$this->newTestedInstance(uniqid(), uniqid())
			)
			->then
				->object($this->testedInstance->shutdown())->isTestedInstance
		;
	}

	function testShutdownOnlyReading()
	{
		$this
			->if(
				$this->newTestedInstance(uniqid(), uniqid())
			)
			->then
				->object($this->testedInstance->shutdownOnlyReading())->isTestedInstance
		;
	}

	function testShutdownOnlyWriting()
	{
		$this
			->if(
				$this->newTestedInstance(uniqid(), uniqid())
			)
			->then
				->object($this->testedInstance->shutdownOnlyWriting())->isTestedInstance
		;
	}

	function testDisconnect()
	{
		$this
			->if(
				$this->newTestedInstance(uniqid(), uniqid())
			)
			->then
				->object($this->testedInstance->disconnect())->isTestedInstance
		;
	}
}
