<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class port extends string implements net\port
{
	function __construct($value)
	{
		try
		{
			parent::__construct($value);
		}
		catch (\exception $exception)
		{
			throw new port\exception('Value can not be converted to string');
		}

		switch (true)
		{
			case $value === '':
			case $value < 0:
			case $value > 65535:
			case filter_var($value, FILTER_VALIDATE_INT) === false:
				throw new port\exception('Port \'' . $value . '\' is invalid');

			default:
		}
	}
}
