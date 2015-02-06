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
				$host = new net\host,
				$port = new net\port,
				$buffer = new buffer,
				$this->function->socket_connect = true,
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

			->when(function() use ($buffer) { $this->testedInstance->resource; $clone = clone $this->testedInstance; $clone->resource; })
			->then
				->function('socket_create')->twice
		;
	}
}
