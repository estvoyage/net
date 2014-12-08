<?php

namespace estvoyage\net;

use
	estvoyage\value\world as value
;

final class port
{
	use value\integer\unsigned {
		validate as isUnsignedInteger;
	}

	function __construct($value)
	{
		if (! self::validate($value))
		{
			throw new \domainException('Port should be an integer greater than or equal to 0 and less than 65536');
		}

		$this->initAsInteger($value);
	}

	static function validate($value)
	{
		return self::isUnsignedInteger($value) && self::isInValidRange($value);
	}

	private static function isInValidRange($value)
	{
		return $value <= 65535;
	}
}
