<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net
;

class udp extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/host.php';
		require_once 'mock/net/port.php';
	}

	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\net\socket')
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
		;
	}
}
