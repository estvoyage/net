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
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance->__destruct()
			)
			->then
				->function('socket_close')->never

			->if(
				$this->newTestedInstance->write(uniqid(), uniqid(), uniqid(), new net\socket\observer)->__destruct()
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
				$this->newTestedInstance
			)
			->when(function() { clone $this->testedInstance; })
			->then
				->function('socket_create')->never

			->when(function() { $clone = clone $this->testedInstance->write(uniqid(), uniqid(), uniqid(), new net\socket\observer); $clone->write(uniqid(), uniqid(), uniqid(), new net\socket\observer); })
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
				$id = uniqid(),
				$observer = new net\socket\observer,

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errno = rand(- PHP_INT_MAX, PHP_INT_MAX)
			)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->write($data, $host, $port, $observer, $id))->isTestedInstance
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $host, $port)->once
				->mock($observer)->call('dataSentOnSocket')->withIdenticalArguments($data, $id, $this->testedInstance)->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->write($data, $host, $port, $observer, $id))->isTestedInstance
				->mock($observer)->call('dataNotFullySentOnSocket')->withArguments($data, $id, 2, $this->testedInstance)->once

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->object($this->testedInstance->write($data, $host, $port, $observer, $id))->isTestedInstance
				->mock($observer)->call('dataNotSentOnSocket')->withArguments($data, $id, $errno, $this->testedInstance)->once
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
