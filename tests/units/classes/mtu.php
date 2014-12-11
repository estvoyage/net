<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\mtu as testedClass
;

class mtu extends test
{
	/**
	 * @dataProvider validValueProvider
	 */
	function testBuildWithValidValue($value)
	{
		$this->integer(testedClass::build($value)->asInteger)->isEqualTo($value);
	}

	/**
	 * @dataProvider invalidValueProvider
	 */
	function testConstructorWithInvalidValue($value)
	{
		$this->exception(function() use ($value) { testedClass::build($value); })
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
				$mtu = testedClass::build($value)
			)
			->then
				->integer($mtu->asInteger)->isIdenticalTo($value)
				->exception(function() use ($mtu, & $property) { $mtu->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($mtu) . '::' . $property)

				->boolean(isset($mtu->asInteger))->isTrue
				->boolean(isset($mtu->{uniqid()}))->isFalse
		;
	}

	function testImmutability()
	{
		$this
			->given(
				$value = rand(68, PHP_INT_MAX)
			)
			->if(
				$mtu = testedClass::build($value)
			)
			->then
				->exception(function() use ($mtu) { $mtu->{uniqid()} = uniqid(); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($mtu) . ' is immutable')

				->exception(function() use ($mtu) { unset($mtu->{uniqid()}); })
					->isInstanceOf('logicException')
					->hasMessage(get_class($mtu) . ' is immutable')
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
