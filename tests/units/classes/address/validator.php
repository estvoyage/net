<?php

namespace estvoyage\net\tests\units\address;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class validator extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\address\validator')
		;
	}

	function testValidate()
	{
		$this
			->given(
				$host = uniqid(),
				$this->calling($hostValidator = new net\host\validator)->validate = function($host, $ok, $ko) { $ok($host); },

				$port = uniqid(),
				$this->calling($portValidator = new net\port\validator)->validate = function($port, $ok, $ko) { $ok($port); },

				$ok = function($host, $port) use (& $hostOk, & $portOk) { $hostOk = $host; $portOk = $port; },
				$ko = function($host, $port) use (& $hostKo, & $portKo) { $hostKo = $host; $portKo = $port; }
			)
			->if(
				$this->newTestedInstance($hostValidator, $portValidator)
			)
			->then
				->object($this->testedInstance->validate($host, $port, $ok))->isTestedInstance
				->mock($hostValidator)->call('validate')->withArguments($host)->once
				->mock($portValidator)->call('validate')->withArguments($port)->once
				->string($hostOk)->isIdenticalTo($host)
				->string($portOk)->isIdenticalTo($port)

			->if(
				$this->calling($hostValidator)->validate = function($host, $ok, $ko) { $ko($host); }
			)
			->then
				->object($this->testedInstance->validate($host, $port, $ok))->isTestedInstance
				->mock($hostValidator)->call('validate')->withArguments($host)->twice
				->mock($portValidator)->call('validate')->withArguments($port)->once

				->object($this->testedInstance->validate($host, $port, $ok, $ko))->isTestedInstance
				->mock($hostValidator)->call('validate')->withArguments($host)->thrice
				->mock($portValidator)->call('validate')->withArguments($port)->once
				->string($hostKo)->isIdenticalTo($host)
				->string($portKo)->isIdenticalTo($port)

			->if(
				$hostKo = null,
				$portKo = null,
				$this->calling($hostValidator)->validate = function($host, $ok) { $ok($host); },
				$this->calling($portValidator)->validate = function($port, $ok, $ko) { $ko($port); }
			)
			->then
				->object($this->testedInstance->validate($host, $port, $ok))->isTestedInstance
				->mock($hostValidator)->call('validate')->withArguments($host)->{4}
				->mock($portValidator)->call('validate')->withArguments($port)->twice

				->object($this->testedInstance->validate($host, $port, $ok, $ko))->isTestedInstance
				->mock($hostValidator)->call('validate')->withArguments($host)->{5}
				->mock($portValidator)->call('validate')->withArguments($port)->thrice
				->string($hostKo)->isIdenticalTo($host)
				->string($portKo)->isIdenticalTo($port)
		;
	}
}
