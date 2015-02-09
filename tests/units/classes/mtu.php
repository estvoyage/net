<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\mtu as testedClass
;

class mtu extends test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\integer\unsigned')
			->isFinal
		;
	}

	/**
	 * @dataProvider validValueProvider
	 */
	function testConstructordWithValidValue($value)
	{
		$this->integer($this->newTestedInstance($value)->asInteger)->isEqualTo($value);
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($value)
	{
		$this->exception(function() use ($value) { $this->newTestedInstance($value); })
			->isInstanceOf('domainException')
			->hasMessage('Argument should be an integer greater than or equal to 68')
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
				$value = rand(68, PHP_INT_MAX)
			)
			->if(
				$this->newTestedInstance($value)
			)
			->then
				->integer($this->testedInstance->asInteger)->isIdenticalTo($value)

				->exception(function() use (& $property) { $this->testedInstance->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($this->testedInstance) . '::' . $property)

				->boolean(isset($this->testedInstance->asInteger))->isTrue
				->boolean(isset($this->testedInstance->{uniqid()}))->isFalse
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$value = rand(68, PHP_INT_MAX)
			)
			->if(
				$this->newTestedInstance($value)
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
			'any integer greater than or equal to 68' => rand(68, PHP_INT_MAX)
		];
	}

	protected function invalidValueProvider()
	{
		return [
			'null' => null,
			'true' => true,
			'false' => false,
			'empty string' => '',
			'any string' => uniqid() . ' ' . uniqid(),
			'any negative integer' => - rand(1, PHP_INT_MAX),
			'zero as integer',
			'any integer between 1 and 67' => rand(1, 67),
			'any integer as float' => (float) rand(-PHP_INT_MAX, PHP_INT_MAX),
			'array' => [ [] ],
			'object' => new \stdclass
		];
	}
}
