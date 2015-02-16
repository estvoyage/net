<?php

namespace estvoyage\net\tests\units\socket\client\sockets;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket\client
;

class exception extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket/client/sockets/socket.php';
	}

	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\net\socket\exception')
		;
	}

	function testIfNoSocketErrorOccured()
	{
		$this
			->given(
				$this->function->socket_last_error = 0
			)
			->then
				->exception(function() { $this->newTestedInstance; })
					->isInstanceOf('logicException')
					->hasMessage('No socket error occured')
		;
	}

	function testIfAnErrorOccured()
	{
		$this
			->given(
				$this->function->socket_last_error = $errorCode = rand(1, PHP_INT_MAX),
				$this->function->socket_strerror = $errorMessage = uniqid(),
				$socket = uniqid()

			)

			->if(
				$this->newTestedInstance
			)
			->then
				->integer($this->testedInstance->getCode())->isEqualTo($errorCode)
				->string($this->testedInstance->getMessage())->isEqualTo($errorMessage)
				->function('socket_last_error')->wasCalledWithArguments(null)->once

			->if(
				$this->newTestedInstance($socket)
			)
			->then
				->integer($this->testedInstance->getCode())->isEqualTo($errorCode)
				->string($this->testedInstance->getMessage())->isEqualTo($errorMessage)
				->function('socket_last_error')->wasCalledWithArguments($socket)->once
		;
	}
}
