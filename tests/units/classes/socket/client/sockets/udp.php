<?php

namespace estvoyage\net\tests\units\socket\client\sockets;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	estvoyage\data,
	mock\estvoyage\data as mockOfData
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
			->extends('estvoyage\net\socket\client\socket')
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

	function testDataConsumerControllerIs()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$dataConsumerController = new mockOfData\consumer\controller
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->dataConsumerControllerIs($dataConsumerController))
					->isNotTestedInstance
					->isEqualTo($this->newTestedInstance($host, $port, $dataConsumerController))
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
				$this->newTestedInstance($host, $port, $controller)
			)

			->if(
				$this->calling($controller)->newData = $controllerWithData = new mockOfData\consumer\controller,
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
				->mock($controller)
					->receive('newData')
						->withArguments($data)
							->once
				->mock($controllerWithData)
					->receive('numberOfBytesConsumedByDataConsumerIs')
						->withArguments($this->testedInstance, new data\data\numberOfBytes(strlen($data)))
							->once

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
				$this->function->socket_send = 0,
				$this->testedInstance->newData($data)
			)
			->then
				->mock($controllerWithData)
					->receive('numberOfBytesConsumedByDataConsumerIs')
						->withArguments($this->testedInstance, new data\data\numberOfBytes)
							->once
		;
	}

	function testNoMoreData()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port
			)

			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->noMoreData())->isTestedInstance
		;
	}
}
