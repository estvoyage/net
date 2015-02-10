<?php

namespace estvoyage\net\tests\units\socket\client\sockets;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	estvoyage\net\socket
;

class writeBuffer extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket/client/sockets/socket.php';
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
				$data = new socket\data(uniqid()),
				$this->newTestedInstance($socket)
			)

			->if(
				$this->function->socket_send = strlen($data)
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->function('socket_send')->wasCalledWithArguments($resource, $data, strlen($data), 0)->once

			->if(
				$this->function->socket_send[2] = 2,
				$this->function->socket_send[3] = 0,
				$this->function->socket_send[4] = strlen($data) - 2
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->function('socket_send')->wasCalledWithArguments($resource, $data, strlen($data), 0)->twice
				->function('socket_send')->wasCalledWithArguments($resource, $data->shift(new socket\data\byte(2)), strlen($data->shift(new socket\data\byte(2))), 0)->twice

			->if(
				$this->function->socket_send[5] = false,
				$this->function->socket_last_error = $errno = rand(0, PHP_INT_MAX)
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode($errno)
		;
	}
}
