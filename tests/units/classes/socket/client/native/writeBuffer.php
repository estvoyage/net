<?php

namespace estvoyage\net\tests\units\socket\client\native;

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
				$this->function->fwrite = strlen($data)
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->function('fwrite')->wasCalledWithArguments($resource, $data, strlen($data))->once

			->if(
				$this->function->fwrite[2] = 2,
				$this->function->fwrite[3] = 0,
				$this->function->fwrite[4] = strlen($data) - 2
			)
			->then
				->object($this->testedInstance->newData($data))->isTestedInstance
				->function('fwrite')->wasCalledWithArguments($resource, $data, strlen($data))->twice
				->function('fwrite')->wasCalledWithArguments($resource, $data->shift(new socket\data\byte(2)), strlen($data->shift(new socket\data\byte(2))))->twice

			->if(
				$this->function->fwrite[5] = function() { trigger_error('fwrite(): send of 4 bytes failed with errno=61 Connection refused in php shell code on line 1', E_USER_WARNING); return 0; }
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode(61)
					->hasMessage('fwrite(): send of 4 bytes failed with errno=61 Connection refused in php shell code on line 1')

			->if(
				$this->function->fwrite[6] = function() use (& $errorMessage) { trigger_error($errorMessage = uniqid(), E_USER_WARNING); return 0; }
			)
			->then
				->exception(function() use ($data) { $this->testedInstance->newData($data); })
					->isInstanceOf('estvoyage\net\socket\exception')
					->hasCode(0)
					->hasMessage($errorMessage)
		;
	}
}
