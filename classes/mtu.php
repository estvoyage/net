<?php

namespace estvoyage\net;

use
	estvoyage\value\world\integer
;

final class mtu
{
	use integer\unsigned {
		__construct as private;
		validate as private isUnsignedInteger;
	}

	static function build($value)
	{
		static $instances = [];

		if (! self::validate($value))
		{
			throw new \domainException('Argument should be an integer greater than or equal to 68');
		}

		if (! isset($instances[$value]))
		{
			$instances[$value] = new self($value);
		}

		return $instances[$value];
	}

	static function validate($value)
	{
		return self::isUnsignedInteger($value) && self::isInValidRange($value);
	}

	private function __construct($value)
	{
		$this->initAsInteger($value);
	}

	private static function isInValidRange($value)
	{
		return $value >= 68;
	}
}
