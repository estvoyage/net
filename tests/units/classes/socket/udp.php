<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket,
	estvoyage\net\address
;

class udp extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/socket/data.php';
		require_once 'mock/address.php';
	}

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
				$address = new address,
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto->doesNothing,
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance($address)->__destruct()
			)
			->then
				->function('socket_close')->never

			->if(
				$this->newTestedInstance($address)->write(new socket\data),
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
				$address = new address,
				$this->function->socket_create[1] = $resource = uniqid(),
				$this->function->socket_create[2] = $otherResource = uniqid(),
				$this->function->socket_sendto->doesNothing,
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance($address)
			)
			->when(function() { clone $this->testedInstance; })
			->then
				->function('socket_create')->never

			->when(function() { $this->testedInstance->write(new socket\data); $clone = clone $this->testedInstance; $clone->write(new socket\data); })
			->then
				->function('socket_create')->twice
		;
	}

	function testWrite()
	{
		$this
			->given(
				$address = new address(uniqid(), uniqid()),
				$data = new socket\data(uniqid()),

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errno = rand(0, PHP_INT_MAX)
			)

			->if(
				$this->newTestedInstance($address)
			)
			->then
				->object($this->testedInstance->write($data))->isEqualTo(new socket\data)
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $address->host, $address->port)->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->write($data))->isEqualTo(new socket\data(substr($data, 2)))

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->write($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
		;
	}

	function testWriteAll()
	{
		$this
			->given(
				$address = new address(uniqid(), uniqid()),
				$data = new socket\data(uniqid()),

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errno = rand(0, PHP_INT_MAX)
			)

			->if(
				$this->newTestedInstance($address)
			)
			->then
				->object($this->testedInstance->writeAll($data))->isTestedInstance
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $address->host, $address->port)->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->writeAll($data))->isTestedInstance
				->function('socket_sendto')
					->wasCalledWithArguments($resource, $data, strlen($data), 0, $address->host, $address->port)->twice
					->wasCalledWithArguments($resource, substr($data, 2), strlen(substr($data, 2)), 0, $address->host, $address->port)->once

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->writeAll($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
		;
	}

	function testShutdown()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->shutdown())->isTestedInstance
		;
	}

	function testShutdownOnlyReading()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->shutdownOnlyReading())->isTestedInstance
		;
	}

	function testShutdownOnlyWriting()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->shutdownOnlyWriting())->isTestedInstance
		;
	}

	function testDisconnect()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->disconnect())->isTestedInstance
		;
	}
}
