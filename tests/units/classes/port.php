<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\port as testedClass
;

class port extends test
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
	function testConstructorWithValidValue($value)
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
			->hasMessage('Port should be an integer greater than or equal to 0 and less than 65536')
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
				$port = rand(0, 65535)
			)
			->if(
				$this->newTestedInstance($port)
			)
			->then
				->integer($this->testedInstance->asInteger)->isIdenticalTo($port)
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
			->if(
				$this->newTestedInstance(rand(0, 65535))
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
			'min value as integer' => 0,
			'max value as integer' => 65535,
			'any valid value as integer' => rand(1, 65534),
			'min value as float' => 0.,
			'max value as float' => 65535.,
			'any valid value as flaot' => (float) rand(1, 65534),
			'min value as string' => '0',
			'max value as string' => '65535',
			'any valid value as string' => (string) rand(1, 65534)
		];
	}

	protected function invalidValueProvider()
	{
		return [
			'null' => null,
			'true '=> true,
			'false' => false,
			'empty string' => '',
			'any string' => uniqid() . ' ' . uniqid(),
			'any negative integer' => - rand(1, PHP_INT_MAX),
			'any integer greater than max value' => rand(65536, PHP_INT_MAX),
			'a float' => M_PI,
			'an array' => [ [] ],
			'an object' => new \stdclass
		];
	}
}
