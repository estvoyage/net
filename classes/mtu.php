<?php

namespace estvoyage\net;

use
	estvoyage\value\integer
;

final class mtu extends integer\unsigned
{
	use immutable;

	function __construct($value)
	{
		$exception = null;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $exception) {}

		if ($exception || ! self::isInValidRange($value))
		{
			throw new \domainException('MTU should be an integer greater than or equal to 68');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isInValidRange($value);
	}

	private static function isInValidRange($value)
	{
		return $value >= 68;
	}
}
