<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net
;

class exception extends units\test
{
	function beforeTestMethod($method)
	{
		require_once 'mock/net/socket/error.php';
		require_once 'mock/net/socket/error/code.php';
		require_once 'mock/net/socket/error/message.php';
	}

	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\exception')
			->extends('runtimeException')
		;
	}

	function testConstructor()
	{
		$this
			->given(
				$error = new net\socket\error,
				$error->code = new net\socket\error\code($code = rand(- PHP_INT_MAX, PHP_INT_MAX)),
				$error->message = new net\socket\error\message($message = uniqid())
			)
			->if(
				$this->newTestedInstance($error)
			)
			->then
				->integer($this->testedInstance->getCode())->isEqualTo($code)
				->string($this->testedInstance->getMessage())->isEqualTo($message)
		;
	}

	function testProperties()
	{
		$this
			->given(
				$error = new net\socket\error,
				$error->code = new net\socket\error\code($code = rand(- PHP_INT_MAX, PHP_INT_MAX)),
				$error->message = new net\socket\error\message($message = uniqid())
			)
			->if(
				$this->newTestedInstance($error)
			)
			->then
				->object($this->testedInstance->code)->isIdenticalTo($error->code)
				->object($this->testedInstance->message)->isIdenticalTo($error->message)
				->exception(function() use (& $property) { $this->testedInstance->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($this->testedInstance) . '::' . $property)

				->boolean(isset($this->testedInstance->code))->isTrue
				->boolean(isset($this->testedInstance->message))->isTrue
				->boolean(isset($this->testedInstance->{uniqid()}))->isFalse
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$error = new net\socket\error,
				$error->code = new net\socket\error\code,
				$error->message = new net\socket\error\message
			)
			->if(
				$this->newTestedInstance($error)
			)
			->then
				->exception(function() { $this->testedInstance->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($this->testedInstance) . ' is immutable')

				->exception(function() { unset($this->testedInstance->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($this->testedInstance) . ' is immutable')
		;
	}
}
