<?php

namespace estvoyage\net\tests\units\socket\client\sockets;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	mock\estvoyage\net\socket\client
;

class writeBuffer extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket/client/sockets/socket.php';
		require_once 'mock/net/socket/data.php';
	}

	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\net\socket\client\writeBuffer')
		;
	}

	function testNewData()
	{
		$this
			->given(
				$socket = new net\socket\client\sockets\socket($resource = uniqid()),
				$owner = new client\writer,
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
