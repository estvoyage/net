<?php

namespace estvoyage\net\tests\units\socket\client\native;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
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

	function testConstructor()
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
				->object($this->testedInstance)->isEqualTo($this->newTestedInstance($host, $port, new data\consumer\controller\buffer))
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
				$this->newTestedInstance($host, $port, $controller)
			)

			->if(
				$this->calling($controller)->newData = $controllerWithData = new mockOfData\consumer\controller,
				$this->function->fsockopen = function($host, $port, & $errno, & $error)
					use (& $errorCode, & $errorMessage) {
						$errorCode = $errno = rand(1, PHP_INT_MAX);
						$errorMessage = $error = uniqid();
						return false;
					}
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errorCode)
					->hasMessage($errorMessage)
				->function('fsockopen')
					->wasCalledWithArguments('tcp://' . $host, $port->asInteger)
						->once

			->if(
				$this->function->fsockopen = $resource = uniqid(),
				$this->function->fwrite = strlen($data)
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->function('fsockopen')
					->wasCalledWithArguments('tcp://' . $host, $port->asInteger)
						->twice
				->function('fwrite')
					->wasCalledWithArguments($resource, $data, strlen($data))
						->once
				->mock($controller)
					->receive('newData')
						->withArguments($data)
							->once
				->mock($controllerWithData)
					->receive('numberOfBytesConsumedByDataConsumerIs')
						->withArguments($this->testedInstance, new data\data\numberOfBytes(strlen($data)))
							->once

			->if(
				$this->testedInstance->newData($data)
			)
			->then
				->function('fsockopen')
					->wasCalledWithArguments('tcp://' . $host, $port->asInteger)
						->twice

			->if(
				$this->function->fwrite = 0,
				$this->testedInstance->newData($data)
			)
			->then
				->mock($controllerWithData)
					->receive('numberOfBytesConsumedByDataConsumerIs')
						->withArguments($this->testedInstance, new data\data\numberOfBytes)
							->once

			->if(
				$this->function->fwrite = function()
					use ($errorCode, & $errorMessage) {
						trigger_error($errorMessage = uniqid() . ' errno=' . $errorCode . ' ' . uniqid());
					}
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errorCode)
					->hasMessage($errorMessage)
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
