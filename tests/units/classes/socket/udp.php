<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket,
	mock\estvoyage\net\world as net
;

class udp extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket')
		;
	}

	function test__destruct()
	{
		$this
			->given(
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto->doesNothing,
				$this->function->socket_close->doesNothing,

				$this->calling($data = new net\socket\data)->__toString = uniqid()
			)
			->if(
				$this->newTestedInstance->__destruct()
			)
			->then
				->function('socket_close')->never

			->if(
				$this->newTestedInstance->write($data, new net\host, new net\port)->__destruct()
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
				$this->function->socket_close->doesNothing,

				$this->calling($data = new net\socket\data)->__toString = uniqid()
			)
			->if(
				$this->newTestedInstance
			)
			->when(function() { clone $this->testedInstance; })
			->then
				->function('socket_create')->never

			->when(function() use ($data) { $clone = clone $this->testedInstance->write($data, new net\host, new net\port); $clone->write($data, new net\host, new net\port); })
			->then
				->function('socket_create')->twice
		;
	}

	function testWrite()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,

				$this->calling($data = new net\socket\data)->__toString = uniqid(),

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errorCode = rand(1, PHP_INT_MAX),
				$this->function->socket_strerror = $errorString = uniqid()
			)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->write($data, $host, $port))->isTestedInstance
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $host, $port)->once
				->mock($data)->call('sentTo')->withIdenticalArguments($this->testedInstance, $host, $port)->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->write($data, $host, $port))->isTestedInstance
				->mock($data)->call('notFullySentTo')->withArguments($this->testedInstance, $host, $port, new socket\data\offset(0), new socket\data\offset(strlen($data) - 2))->once

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->object($this->testedInstance->write($data, $host, $port))->isTestedInstance
				->mock($data)->call('notSentTo')->withArguments($this->testedInstance, $host, $port, new socket\data\offset(0), new socket\error(null))->once
		;
	}

	function testShutdown()
	{
		$this
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->shutdown())->isTestedInstance
		;
	}

	function testShutdownOnlyReading()
	{
		$this
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->shutdownOnlyReading())->isTestedInstance
		;
	}

	function testShutdownOnlyWriting()
	{
		$this
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->shutdownOnlyWriting())->isTestedInstance
		;
	}

	function testDisconnect()
	{
		$this
			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->disconnect())->isTestedInstance
		;
	}
}
