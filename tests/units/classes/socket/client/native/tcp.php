<?php

namespace estvoyage\net\tests\units\socket\client\native;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	estvoyage\net\socket\client\native\tcp as testedClass,
	estvoyage\data,
	mock\estvoyage\data as mockedData
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
				$this->function->fsockopen = $resource = uniqid(),
				$this->function->fwrite = 0,
				$this->function->fclose->doesNothing
			)

			->when(function() use ($host, $port) { (new testedClass($host, $port))->__destruct(); })
			->then
				->function('fclose')->never

			->when(function() use ($host, $port) { (new testedClass($host, $port))->newData(new data\data(''))->__destruct(); })
			->then
				->function('fclose')->wasCalledWithArguments($resource)->once
		;
	}

	function test__clone()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$this->function->fsockopen = uniqid(),
				$this->function->fwrite = 0,
				$this->function->fclose->doesNothing
			)

			->when(function() use ($host, $port) {
					$socket = (new testedClass($host, $port))->newData(new data\data(''));
					$clone = clone $socket;
					$clone->newData(new data\data(''));
				}
			)
			->then
				->function('fsockopen')->wasCalledWithArguments('tcp://' . $host, $port->asInteger)->twice
		;
	}

	function testNewData()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$data = new data\data(uniqid()),
				$controller = new mockedData\consumer\controller,
				$this->newTestedInstance($host, $port),
				$this->function->fclose->doesNothing
			)

			->if(
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

			->if(
				$this->function->fsockopen = $resource = uniqid(),
				$this->function->fwrite = strlen($data)
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->function('fsockopen')->wasCalled()->twice
				->function('fwrite')->wasCalledWithArguments($resource, $data, strlen($data))->once


			->if($this->testedInstance->newData($data))
			->then
				->function('fsockopen')->wasCalled()->twice

			->if(
				$this->function->fwrite = 0
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance

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

			->if(
				$this->function->fwrite = 0,
				$this->newTestedInstance($host, $port, $controller)->newData($data)
			)
			->then
				->mock($controller)->receive('dataNotWriteByDataConsumerIs')->withArguments($this->testedInstance, $data)->once
		;
	}
}
