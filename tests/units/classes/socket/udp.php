<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket,
	estvoyage\net\tests\units\mock,
	mock\estvoyage\net\world as net
;

class udp extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\socket')
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
				$this->newTestedInstance->write(new mock\socket\data, new mock\address),
				$this->testedInstance->__destruct()
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

			->when(function() { $this->testedInstance->write(new mock\socket\data, new mock\address); $clone = clone $this->testedInstance; $clone->write(new mock\socket\data, new mock\address); })
			->then
				->function('socket_create')->twice
		;
	}

	function testWrite()
	{
		$this
			->given(
				$address = new mock\address(uniqid(), uniqid()),
				$data = new mock\socket\data(uniqid()),

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errno = rand(0, PHP_INT_MAX)
			)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->write($data, $address))->isEqualTo(new mock\socket\data)
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $address->host, $address->port)->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->write($data, $address))->isEqualTo(new mock\socket\data(substr($data, 2)))

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($data, $address) { $this->testedInstance->write($data, $address); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
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
