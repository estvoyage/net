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
			->hasMessage('MTU should be an integer greater than or equal to 68')
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
			rand(68, PHP_INT_MAX)
		];
	}

	protected function invalidValueProvider()
	{
		return [
			null,
			true,
			false,
			'',
			uniqid(),
			- rand(1, PHP_INT_MAX),
			0,
			rand(1, 67),
			(float) rand(-PHP_INT_MAX, PHP_INT_MAX),
			[ [] ],
			new \stdclass
		];
	}
}
