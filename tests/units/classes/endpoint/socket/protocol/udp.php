<?php

namespace estvoyage\net\tests\units\endpoint\socket\protocol;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world\endpoint
;

class udp extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint\socket\protocol')
			->implements('estvoyage\net\world\endpoint\protocol')
		;
	}

	function test__destruct()
	{
		$this
			->given(
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto->doesNothing,
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance(uniqid(), uniqid())->__destruct()
			)
			->then
				->function('socket_close')->never

			->if(
				$this->newTestedInstance(uniqid(), uniqid())->write(uniqid(), function() {})->__destruct()
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
				$this->function->socket_sendto->doesNothing,
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance(uniqid(), uniqid())
			)
			->when(function() { clone $this->testedInstance; })
			->then
				->function('socket_create')->never

			->when(function() { $clone = clone $this->testedInstance->write(uniqid(), function() {}); $clone->write(uniqid(), function() {}); })
			->then
				->function('socket_create')->twice
		;
	}

	function testWrite()
	{
		$this
			->given(
				$host = uniqid(),
				$port = uniqid(),
				$data = uniqid(),
				$callback = function($data) use (& $dataRemaining) { $dataRemaining = $data; },
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errorCode = rand(1, PHP_INT_MAX),
				$this->function->socket_strerror = $errorString = uniqid()
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->write($data, $callback))->isTestedInstance
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $host, $port)->once
				->string($dataRemaining)->isEmpty

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->write($data, $callback))->isTestedInstance
				->string($dataRemaining)->isEqualTo(substr($data, 2))

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->write($data, function() {}); })
					->isInstanceOf('estvoyage\net\endpoint\socket\protocol\exception')
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
