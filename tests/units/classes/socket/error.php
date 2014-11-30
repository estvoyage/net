<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket\error\code,
	estvoyage\net\socket\error\message
;

class error extends units\test
{
	function testProperties()
	{
		$this

			->given(
				$code = new code(rand(0, PHP_INT_MAX)),
				$this->function->socket_strerror = $message = uniqid()
			)
			->if(
				$this->newTestedInstance($code)
			)
			->then
				->object($this->testedInstance->code)->isIdenticalTo($code)
				->object($this->testedInstance->message)->isEqualTo(new message($message))
				->function('socket_strerror')->wasCalledWithArguments($code->asInteger)->once
				->exception(function() use (& $property) { $this->testedInstance->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($this->testedInstance) . '::' . $property)
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$this->function->socket_strerror = uniqid()
			)
			->if(
				$this->newTestedInstance(new code(rand(0, PHP_INT_MAX)))
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
