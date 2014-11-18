<?php

namespace estvoyage\net\socket\data;

use
	estvoyage\net\string,
	estvoyage\net\world\socket\data
;

class offset extends string implements data\offset
{
	function __construct($value)
	{
		try
		{
			parent::__construct($value);
		}
		catch (\exception $exception)
		{
			throw new offset\exception('Value of type \'' . gettype($value) . '\' can not be used as offset');
		}

		if (! is_int($value))
		{
			throw new offset\exception('Value \'' . $value . '\' is not an integer');
		}

		if ($value < 0)
		{
			throw new offset\exception('Value \'' . $value . '\' is not greater than 0');
		}
	}
}
