<?php

namespace estvoyage\net\tests\units\socket\buffer;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	mock\estvoyage\net\world as mock
;

class write extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket.php';
		require_once 'mock/net/socket/data.php';
	}

	function testClass()
	{
		$this->testedClass
			->isFinal
		;
	}

	function testNewData()
	{
		$this
			->given(
				$socket = new net\socket($resource = uniqid()),
				$owner = new mock\socket\writer,
				$data = new net\socket\data(uniqid()),
				$this->function->socket_send = strlen($data),
				$this->function->socket_last_error = $errno = rand(0, PHP_INT_MAX)
			)
			->if(
				$this->newTestedInstance($socket, $owner)
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->mock($owner)->receive('remainingDataInSocketBufferAre')->never
				->function('socket_send')->wasCalledWithArguments($resource, $data, strlen($data), 0)->once

			->if(
				$this->function->socket_send[2] = 2
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->mock($owner)->receive('remainingDataInSocketBufferAre')->withArguments(new net\socket\data(substr($data, 2)))->once

			->if(
				$this->function->socket_send[3] = false
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
		;
	}
}
