<?php

namespace estvoyage\net\tests\units\socket\client\native;

require __DIR__ . '/../../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net,
	mock\estvoyage\net\socket\client
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
				$this->function->fsockopen = $resource = uniqid(),
				$this->function->fclose->doesNothing
			)
			->if(
				$this->function->is_resource = false,
				$this->newTestedInstance($host, $port)->__destruct()
			)
			->then
				->function('fclose')->never

			->if(
				$this->function->is_resource = false,
				$this->newTestedInstance($host, $port)->resource,
				$this->function->is_resource = true,
				$this->testedInstance->__destruct()
			)
			->then
				->function('fclose')->wasCalledWithArguments($resource)->once

			->if(
				$this->function->is_resource = false,
				$this->newTestedInstance($host, $port)->resource,
				$this->testedInstance->__destruct()
			)
			->then
				->function('fclose')->wasCalledWithArguments($resource)->once
		;
	}

	function test__clone()
	{
		$this
			->given(
				$this->function->fsockopen[1] = $resource = uniqid(),
				$this->function->fsockopen[2] = $otherResource = uniqid(),
				$this->function->fclose->doesNothing
			)

			->if(
				$this->newTestedInstance(new net\host, new net\port),
				clone $this->testedInstance
			)
			->then
				->function('fsockopen')->never

			->if(
				$this->testedInstance->resource,
				$clone = clone $this->testedInstance,
				$clone->resource
			)
			->then
				->function('fsockopen')->twice
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$this->function->fsockopen = $resource = uniqid(),
				$this->function->fclose->doesNothing
			)
			->if(
				$this->newTestedInstance(new net\host, new net\port)
			)
			->then
				->string($this->testedInstance->resource)->isEqualTo($resource)
		;
	}

	function testBuildWriteBuffer()
	{
		$this
			->object($this->newTestedInstance(new net\host, new net\port)->buildWriteBuffer())
				->isEqualTo(new net\socket\client\native\writeBuffer($this->testedInstance))
		;
	}
}
