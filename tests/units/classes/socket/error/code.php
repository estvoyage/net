<?php

namespace estvoyage\net\tests\units\socket\error;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units
;

class code extends units\test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\integer\unsigned')
		;
	}

	function testProperties()
	{
		$this

			->given(
				$code = rand(0, PHP_INT_MAX)
			)
			->if(
				$this->newTestedInstance($code)
			)
			->then
				->integer($this->testedInstance->asInteger)->isIdenticalTo($code)
				->exception(function() use (& $property) { $this->testedInstance->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($this->testedInstance) . '::' . $property)
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$code = rand(0, PHP_INT_MAX)
			)
			->if(
				$this->newTestedInstance($code)
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
