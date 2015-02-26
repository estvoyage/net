<?php

namespace estvoyage\net\tests\units\socket\client\native;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	estvoyage\net\socket\client\native\udp as testedClass,
	estvoyage\data,
	mock\estvoyage\data as mockedData
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

	function test__destruct()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$dataProvider = new mockedData\provider,
				$this->function->fsockopen = $resource = uniqid(),
				$this->function->fclose->doesNothing
			)

			->when(function() use ($host, $port) { (new testedClass($host, $port)); })
			->then
				->function('fclose')->never

			->when(function() use ($host, $port, $dataProvider) { (new testedClass($host, $port))->dataProviderIs($dataProvider); })
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
				$dataProvider = new mockedData\provider,
				$this->function->fsockopen = uniqid(),
				$this->function->fclose->doesNothing
			)

			->when(function() use ($host, $port, $dataProvider) {
					$socket = (new testedClass($host, $port))->dataProviderIs($dataProvider);
					$clone = clone $socket;
					$clone->dataProviderIs($dataProvider);
				}
			)
			->then
				->function('fsockopen')->wasCalledWithArguments('udp://' . $host, $port->asInteger)->twice
		;
	}

	function testNewData()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$data = new data\data(uniqid())
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\client\exception\logic')
					->hasMessage('Data provider is undefined')
		;
	}

	function testDataProviderIs()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port,
				$data = new data\data(uniqid()),
				$dataProvider1 = new mockedData\provider,
				$dataProvider2 = new mockedData\provider,
				$this->newTestedInstance($host, $port),
				$this->function->fsockopen = $resource = uniqid(),
				$this->function->fclose->doesNothing
			)

			->if(
				$this->function->fwrite = strlen($data),
				$this->calling($dataProvider1)->useDataConsumer = function($dataConsumer) use ($data) {
					$dataConsumer->newData($data);
				}
			)
			->then
				->object($this->testedInstance->dataProviderIs($dataProvider1))->isTestedInstance
				->function('fsockopen')->wasCalled()->once
				->function('fwrite')
					->wasCalledWithArguments($resource, $data, strlen($data))
						->once
				->mock($dataProvider1)
					->receive('lengthOfDataWrittenIs')->withArguments(new data\data\length(strlen($data)))
						->once
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\client\exception\logic')
					->hasMessage('Data provider is undefined')

				->object($this->testedInstance->dataProviderIs($dataProvider1))->isTestedInstance
				->function('fsockopen')->wasCalled()->once

			->if(
				$this->calling($dataProvider2)->useDataConsumer = function($dataConsumer) use ($data) {
					$dataConsumer->newData($data);
				},
				$this->calling($dataProvider1)->useDataConsumer = function($dataConsumer) use ($data, $dataProvider2) {
					$dataConsumer->dataProviderIs($dataProvider2);
					$dataConsumer->newData($data);
				}
			)
			->then
				->object($this->testedInstance->dataProviderIs($dataProvider1))->isTestedInstance
				->function('fsockopen')->wasCalled()->once
				->mock($dataProvider1)->receive('lengthOfDataWrittenIs')->withArguments(new data\data\length(strlen($data)))->thrice
		;
	}
}
