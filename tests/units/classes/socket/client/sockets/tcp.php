<?php

namespace estvoyage\net\tests\units\socket\client\sockets;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	estvoyage\net\socket\client\sockets\tcp as testedClass,
	estvoyage\data,
	mock\estvoyage\data as mockOfData
;

class tcp extends units\test
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
				$this->function->socket_send = 0,
				$this->function->socket_close->doesNothing
			)

			->when(function() use ($host, $port) { (new testedClass($host, $port)); })
			->then
				->function('socket_close')->never

			->when(function() use ($host, $port) { (new testedClass($host, $port))->newData(new data\data('')); })
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
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_connect = true,
				$this->function->socket_send = 0,
				$this->function->socket_close->doesNothing
			)

			->when(function() use ($host, $port) {
					$socket = (new testedClass($host, $port))->newData(new data\data(''));
					$clone = clone $socket;
					$clone->newData(new data\data(''));
				}
			)
			->then
				->function('socket_create')->wasCalledWithArguments(AF_INET, SOCK_STREAM, SOL_TCP)->twice
		;
	}

	function testDataProviderIs()
	{
		$this
			->given(
					$dataProvider = new mockOfData\provider
			)
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->object($this->testedInstance->dataProviderIs($dataProvider))->isTestedInstance
				->mock($dataProvider)
					->receive('dataConsumerIs')
						->withArguments($this->testedInstance)
							->once
		;
	}

	function testNewData()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$data = new data\data(uniqid()),
				$controller = new mockOfData\consumer\controller,
				$this->function->socket_last_error = $errorCode = rand(1, PHP_INT_MAX),
				$this->function->socket_strerror = $errorMessage = uniqid(),
				$this->function->socket_close->doesNothing,
				$this->newTestedInstance($host, $port)
			)

			->if(
				$this->function->socket_create = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errorCode)
					->hasMessage($errorMessage)

			->if(
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_connect = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errorCode)
					->hasMessage($errorMessage)

			->if(
				$this->function->socket_connect = true,
				$this->function->socket_send = strlen($data)
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->function('socket_create')->wasCalled()->thrice
				->function('socket_send')->wasCalledWithArguments($resource, $data, strlen($data), 0)->once

			->if($this->testedInstance->newData($data))
			->then
				->function('socket_create')->wasCalled()->thrice

			->if(
				$this->function->socket_send = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errorCode)
					->hasMessage($errorMessage)

			->if(
				$this->function->socket_send = 0
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance

			->if(
				$this->newTestedInstance($host, $port, $controller)->newData($data)
			)
			->then
				->mock($controller)->receive('dataNotWriteByDataConsumerIs')->withArguments($this->testedInstance, $data)->once
		;
	}

	function testNoMoreData()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$this->function->socket_create = $resource = uniqid(),
				$this->function->socket_connect = true,
				$this->function->socket_send = 0,
				$this->function->socket_close->doesNothing
			)

			->if(
				$this->newTestedInstance($host, $port)->noMoreData()
			)
			->then
				->function('socket_close')->never

			->if(
				$this->newTestedInstance($host, $port)->newData(new data\data)->noMoreData()
			)
			->then
				->function('socket_close')->wasCalledWithArguments($resource)->once
		;
	}
}
