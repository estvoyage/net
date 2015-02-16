<?php

namespace estvoyage\net\tests\units\socket\client\sockets;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	mock\estvoyage\net\socket\client
;

class tcp extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/host.php';
		require_once 'mock/net/port.php';
		require_once 'mock/net/socket/client/sockets/exception.php';
	}

	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\net\socket\client\socket')
		;
	}

	function test__destruct()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_connect = true,
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->function->is_resource = false,
				$this->newTestedInstance($host, $port)->__destruct()
			)
			->then
				->function('socket_close')->never

			->if(
				$this->function->is_resource = false,
				$this->newTestedInstance($host, $port)->resource,
				$this->function->is_resource = true,
				$this->testedInstance->__destruct()
			)
			->then
				->function('socket_close')->wasCalledWithArguments($resource)->once

			->if(
				$this->function->is_resource = false,
				$this->newTestedInstance($host, $port)->resource,
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
				$this->function->socket_connect = true,
				$this->function->socket_create[1] = $resource = uniqid(),
				$this->function->socket_create[2] = $otherResource = uniqid(),
				$this->function->socket_close->doesNothing
			)

			->if(
				$this->newTestedInstance(new net\host, new net\port),
				clone $this->testedInstance
			)
			->then
				->function('socket_create')->never

			->if(
				$this->testedInstance->resource,
				$clone = clone $this->testedInstance,
				$clone->resource
			)
			->then
				->function('socket_create')->twice
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$this->function->socket_connect = true,
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->string($this->testedInstance->resource)->isEqualTo($resource)

			->if(
				$this->function->socket_create = false,
				$this->function->socket_last_error = $errorCode = rand(1, PHP_INT_MAX),
				$this->function->socket_strerror = $errorMessage = uniqid(),
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->exception(function() { $this->testedInstance->resource; })
					->isInstanceOf('estvoyage\net\socket\client\sockets\exception')
		;
	}

	function testBuildWriteBuffer()
	{
		$this
			->object($this->newTestedInstance(new net\host, new net\port)->buildWriteBuffer())
				->isEqualTo(new net\socket\client\sockets\writeBuffer($this->testedInstance))
		;
	}
}
