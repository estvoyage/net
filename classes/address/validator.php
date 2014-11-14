<?php

namespace estvoyage\net\address;

use
	estvoyage\net\world as net
;

class validator implements net\address\validator
{
	private
		$hostValidator,
		$portValidator
	;

	function __construct(net\host\validator $hostValidator, net\port\validator $portValidator)
	{
		$this->hostValidator = $hostValidator;
		$this->portValidator = $portValidator;
	}

	function validate($host, $port, callable $ok, callable $ko = null)
	{
		$ko = $ko ?: function() {};

		$this->hostValidator
			->validate(
				$host,
				function($host) use ($port, $ok, $ko) {
					$this->portValidator
						->validate(
							$port,
							function($port) use ($host, $ok) { $ok($host, $port); },
							function($port) use ($host, $ko) { $ko($host, $port); }
						)
					;
				},
				function($host) use ($port, $ko) { $ko($host, $port); }
			)
		;

		return $this;
	}
}
