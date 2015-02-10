<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket
;

class data extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket/data/byte.php';
	}

	function testClass()
	{
		$this->testedClass
			->isFinal
			->extends('estvoyage\value\string')
		;
	}

	function testShift()
	{
		$this
			->given(
				$zeroByte = new socket\data\byte,
				$oneByte = new socket\data\byte(1),
				$fourBytes = new socket\data\byte(4),
				$anyBytes = new socket\data\byte(rand(1, PHP_INT_MAX))
			)

			->if(
				$this->newTestedInstance
			)
			->then
				->object($this->testedInstance->shift($zeroByte))->isTestedInstance
				->object($this->testedInstance->shift($anyBytes))->isTestedInstance

			->if(
				$this->newTestedInstance('123456789')
			)
			->then
				->object($this->testedInstance->shift($oneByte))->isEqualTo($this->newTestedInstance('23456789'))
				->object($this->testedInstance->shift($fourBytes))->isEqualTo($this->newTestedInstance('6789'))
				->object($this->testedInstance->shift($fourBytes))->isEqualTo($this->newTestedInstance)
		;
	}
}
