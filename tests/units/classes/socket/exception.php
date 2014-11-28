<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\host as shost,
	estvoyage\net\port as sport,
	estvoyage\net\address as saddress,
	estvoyage\net\socket\error as serror,
	mock\estvoyage\net\world\socket\exception\formatter
;

class exception extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\exception')
			->extends('exception')
		;
	}

	function testConstructor()
	{
		$this
			->given(
				$error = new serror(new serror\code(rand(1, PHP_INT_MAX)), new serror\message(uniqid()))
			)
			->if(
				$this->newTestedInstance($error)
			)
			->then
				->integer($this->testedInstance->getCode())->isEqualTo($error->code->asInteger)
				->string($this->testedInstance->getMessage())->isEqualTo($error->message->asString)
		;
	}

	function testProperties()
	{
		$this
			->given(
				$error = new serror(new serror\code(rand(1, PHP_INT_MAX)), new serror\message(uniqid()))
			)
			->if(
				$this->newTestedInstance($error)
			)
			->then
				->object($this->testedInstance->code)->isEqualTo($error->code)
				->object($this->testedInstance->message)->isEqualTo($error->message)
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
			->if(
				$this->newTestedInstance(new serror(new serror\code(rand(1, PHP_INT_MAX)), new serror\message(uniqid())))
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
