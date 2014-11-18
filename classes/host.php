<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class host extends string implements net\host
{
	function __construct($value)
	{
		try
		{
			parent::__construct($value);
		}
		catch (\exception $exception)
		{
			throw new host\exception('Value can not be converted to string');
		}

		if (! preg_match('/^[0-9a-z][0-9a-z-]{0,62}(?:\.[0-9a-z-]{1,63}){0,3}$/i', $this))
		{
			throw new host\exception('Host \'' . $this . '\' is invalid');
		}
	}
}
