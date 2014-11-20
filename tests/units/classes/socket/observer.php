<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class observer extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket\observer')
		;
	}

	function testDataSentOnSocket()
	{
		$this
			->given(
				$data = uniqid(),
				$id = uniqid(),
				$socket = new net\socket,
				$dataSent = function($data, $id, $socket) use (& $dataSent, & $idUsed, & $socketUsed) {
					$dataSent = $data;
					$idUsed = $id;
					$socketUsed = $socket;
				}
			)
			->if(
				$this->newTestedInstance(function() {}, function() {}, $dataSent)
			)
			->then
				->object($this->testedInstance->dataSentOnSocket($data, $id, $socket))->isTestedInstance
				->string($dataSent)->isEqualTo($data)
				->string($idUsed)->isEqualTo($id)
				->object($socketUsed)->isIdenticalTo($socket)
		;
	}

	function testDataNotFullySentOnSocket()
	{
		$this
			->given(
				$data = uniqid(),
				$id = uniqid(),
				$bytes = rand(0, PHP_INT_MAX),
				$socket = new net\socket,
				$dataNotFullySent = function($data, $bytes, $id, $socket) use (& $dataSent, & $idUsed, & $bytesWritten, & $socketUsed) {
					$dataSent = $data;
					$bytesWritten = $bytes;
					$idUsed = $id;
					$socketUsed = $socket;
				}
			)
			->if(
				$this->newTestedInstance($dataNotFullySent, function() {}, function() {})
			)
			->then
				->object($this->testedInstance->dataNotFullySentOnSocket($data, $bytes, $id, $socket))->isTestedInstance
				->string($dataSent)->isEqualTo($data)
				->string($idUsed)->isEqualTo($id)
				->integer($bytesWritten)->isEqualTo($bytes)
				->object($socketUsed)->isIdenticalTo($socket)
		;
	}

	function testDataNotSentOnSocket()
	{
		$this
			->given(
				$data = uniqid(),
				$errno = rand(0, PHP_INT_MAX),
				$id = uniqid(),
				$socket = new net\socket,
				$dataNotSent = function($data, $errno, $id, $socket) use (& $dataSent, & $idUsed, & $errnoEncoutered, & $socketUsed) {
					$dataSent = $data;
					$errnoEncoutered = $errno;
					$idUsed = $id;
					$socketUsed = $socket;
				}
			)
			->if(
				$this->newTestedInstance(function() {}, $dataNotSent, function() {})
			)
			->then
				->object($this->testedInstance->dataNotSentOnSocket($data, $errno, $id, $socket))->isTestedInstance
				->string($dataSent)->isEqualTo($data)
				->string($idUsed)->isEqualTo($id)
				->integer($errnoEncoutered)->isEqualTo($errno)
				->object($socketUsed)->isIdenticalTo($socket)
		;
	}
}
