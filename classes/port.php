<?php

namespace estvoyage\net;

use
	estvoyage\value\integer
;

final class port extends integer\unsigned
{
	function __construct($value)
	{
		$invalid = false;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $exception)
		{
			$invalid = true;
		}

		if ($invalid || ! self::isInValidRange($value))
		{
			throw new \domainException('Port should be an integer greater than or equal to 0 and less than 65536');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isInValidRange($value);
	}

	private static function isInValidRange($value)
	{
		return $value <= 65535;
	}
}
