<?php

namespace estvoyage\net\port;

use
	estvoyage\net\world as net
;

class validator implements net\port\validator
{
	function validate($value, callable $ok, callable $ko = null)
	{
		switch (true)
		{
			case $value === '':
			case $value < 0:
			case $value > 65535:
			case filter_var($value, FILTER_VALIDATE_INT) === false:
				if ($ko)
				{
					$ko($value);
				}
				break;

			default:
				$ok($value);
		}


		return $this;
	}
}
