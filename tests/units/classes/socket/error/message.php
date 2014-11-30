<?php

namespace estvoyage\net\tests\units\socket\error;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class message extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\string')
		;
	}

	function testProperties()
	{
		$this

			->given(
				$message = uniqid()
			)
			->if(
				$this->newTestedInstance($message)
			)
			->then
				->string($this->testedInstance->asString)->isIdenticalTo($message)
				->exception(function() use (& $property) { $this->testedInstance->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($this->testedInstance) . '::' . $property)
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$message = uniqid()
			)
			->if(
				$this->newTestedInstance($message)
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
