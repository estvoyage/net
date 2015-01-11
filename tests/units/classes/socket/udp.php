<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket,
	estvoyage\net\address,
	mock\estvoyage\net\world\socket\buffer
;

class udp extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket/data.php';
		require_once 'mock/net/address.php';
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
				$buffer = new buffer,
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
				$this->newTestedInstance($address)->shouldSend(new socket\data, $buffer),
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
				$buffer = new buffer,
				$this->function->socket_create[1] = $resource = uniqid(),
				$this->function->socket_create[2] = $otherResource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing
			)
			->if(
				$this->newTestedInstance($address)
			)
			->when(function() { clone $this->testedInstance; })
			->then
				->function('socket_create')->never

			->when(function() { $this->testedInstance->mustSend(new socket\data(uniqid())); $clone = clone $this->testedInstance; $clone->mustSend(new socket\data(uniqid())); })
			->then
				->function('socket_create')->twice
		;
	}

	function testShouldSend()
	{
		$this
			->given(
				$address = new address(uniqid(), uniqid()),
				$data = new socket\data(uniqid()),
				$buffer = new buffer,

				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_sendto = function($resource, $data) { return strlen($data); },
				$this->function->socket_close->doesNothing,
				$this->function->socket_last_error = $errno = rand(0, PHP_INT_MAX)
			)

			->if(
				$this->newTestedInstance($address)
			)
			->then
				->object($this->testedInstance->shouldSend($data, $buffer))->isTestedInstance
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $address->host, $address->port)->once
				->mock($buffer)->call('dataWasNotSent')->never

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->shouldSend($data, $buffer))->isTestedInstance
				->mock($buffer)->call('dataWasNotSent')->withArguments(new socket\data(substr($data, 2)))->once

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($data, $buffer) { $this->testedInstance->shouldSend($data, $buffer); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
		;
	}

	function testMustSend()
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
				->object($this->testedInstance->mustSend($data))->isTestedInstance
				->function('socket_sendto')->wasCalledWithArguments($resource, $data, strlen($data), 0, $address->host, $address->port)->once

			->if(
				$this->function->socket_sendto[2] = 2
			)
			->then
				->object($this->testedInstance->mustSend($data))->isTestedInstance
				->function('socket_sendto')
					->wasCalledWithArguments($resource, $data, strlen($data), 0, $address->host, $address->port)->twice
					->wasCalledWithArguments($resource, substr($data, 2), strlen(substr($data, 2)), 0, $address->host, $address->port)->once

			->if(
				$this->function->socket_sendto = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->mustSend($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
		;
	}

	function testNoMoreDataToSendOrReceive()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->noMoreDataToSendOrReceive())->isTestedInstance
		;
	}

	function testNoMoreDataToReceive()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->noMoreDataToReceive())->isTestedInstance
		;
	}

	function testNoMoreDataToSend()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->noMoreDataToSend())->isTestedInstance
		;
	}

	function testIsNowUseless()
	{
		$this
			->if(
				$this->newTestedInstance(new address)
			)
			->then
				->object($this->testedInstance->IsNowUseless())->isTestedInstance
		;
	}
}
