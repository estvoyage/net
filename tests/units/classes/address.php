<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net
;

require_once 'mock/host.php';
require_once 'mock/port.php';

class address extends units\test
{
	function testProperties()
	{
		$this
			->given(
				$host = new net\host,
				$port = new net\port
			)
			->if(
				$this->newTestedInstance($host, $port)
			)
			->then
				->object($this->testedInstance->host)->isIdenticalTo($host)
				->object($this->testedInstance->port)->isIdenticalTo($port)
				->exception(function() use (& $property) { $this->testedInstance->{$property = uniqid()}; })
					->isInstanceOf('logicException')
					->hasMessage('Undefined property: ' . get_class($this->testedInstance) . '::' . $property)

				->boolean(isset($this->testedInstance->host))->isTrue
				->boolean(isset($this->testedInstance->port))->isTrue
				->boolean(isset($this->testedInstance->{uniqid()}))->isFalse
		;
	}

	function testImmutability()
	{
		$this
			->if(
				$this->newTestedInstance(new net\host, new net\port)
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
