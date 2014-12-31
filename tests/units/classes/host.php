<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\host as testedClass
;

class host extends test
{
	function testClass()
	{
		$this->testedClass
			->isFinal
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testValidateWithValidValue($value)
	{
		$this->boolean(testedClass::validate($value))->isTrue;
	}


	/**
	 * @dataProvider invalidValueProvider
	 */
	function testValidateWithInvalidValue($value)
	{
		$this->boolean(testedClass::validate($value))->isFalse;
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

	protected function validValueProvider()
	{
		return [
			'single letter' => 'a',
			'single letter with trainling dot' => 'a.',
			'single digit' => '1',
			'single digit with trailing dot' => '1.',
			'single letter, dot, single digit' => 'a.1',
			'63 letters, dot, 63 digits' => str_repeat('a', 63) . '.' . str_repeat('1', 63)
		];
	}

	protected function invalidValueProvider()
	{
		return [
			'null' => null,
			'true '=> true,
			'false' => false,
			'any integer' => rand(- PHP_INT_MAX, PHP_INT_MAX),
			'any float' => (float) rand(-PHP_INT_MAX, PHP_INT_MAX),
			'an array' => [ [] ],
			'an object' => new \stdclass,
			'empty string' => '',
			'string with more than 254 characters' => str_repeat('a', 255),
			'string with more than 63 characters without dot' => str_repeat('a', 64),
			'single hyphen' => '-',
			'string with trailing hyphen' => str_repeat('a', rand(1, 62)) . '-',
			'string which start with hyphen' => '-' . str_repeat('a', rand(1, 62))
		];
	}
}
