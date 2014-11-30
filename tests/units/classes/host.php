<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

class host extends test
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
				$host = uniqid()
			)
			->if(
				$this->newTestedInstance($host)
			)
			->then
				->string($this->testedInstance->asString)->isIdenticalTo($host)
				->exception(function() use (& $property) { $this->testedInstance->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($this->testedInstance) . '::' . $property)

				->boolean(isset($this->testedInstance->asString))->isTrue
				->boolean(isset($this->testedInstance->{uniqid()}))->isFalse
		;
	}

	function testImmutability()
	{
		$this
			->if(
				$this->newTestedInstance(uniqid())
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
