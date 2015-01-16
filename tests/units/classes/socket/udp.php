<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	estvoyage\net\socket,
	mock\estvoyage\net\world\socket\buffer
;

class udp extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket/data.php';
		require_once 'mock/net/host.php';
		require_once 'mock/net/port.php';
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
				$host = new net\host,
				$port = new net\port,
				$buffer = new buffer,
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto->doesNothing,
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance($host, $port)->__destruct()
			)
			->then
				->function('socket_close')->never

			->if(
				$this->newTestedInstance($host, $port)->bufferContains($buffer, new socket\data),
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
				$host = new net\host,
				$port = new net\port,
				$buffer = new buffer,
				$this->function->socket_create[1] = $resource = uniqid(),
				$this->function->socket_create[2] = $otherResource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->when(function() { clone $this->testedInstance; })
			->then
				->function('socket_create')->never

			->when(function() use ($buffer) { $this->testedInstance->bufferContains($buffer, new socket\data(uniqid())); $clone = clone $this->testedInstance; $clone->bufferContains($buffer, new socket\data(uniqid())); })
			->then
				->function('socket_create')->twice
		;
	}

	function testBufferContains()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$data = new socket\data(uniqid()),
				$buffer = new buffer,

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errno = rand(0, PHP_INT_MAX)
			)

			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->bufferContains($buffer, $data))->isTestedInstance
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $host, $port)->once
				->mock($buffer)->call('remainingData')->never

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->bufferContains($buffer, $data))->isTestedInstance
				->mock($buffer)->call('remainingData')->withArguments(new socket\data(substr($data, 2)))->once

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($buffer, $data) { $this->testedInstance->bufferContains($buffer, $data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
		;
	}
}
