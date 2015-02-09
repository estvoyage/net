<?php

namespace estvoyage\net;

use
	estvoyage\value
;

final class port extends value\integer\unsigned
{
	function __construct($value)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $domainException) {}

		if ($domainException || ! self::isPort($value))
		{
			throw new \domainException('Port should be an integer greater than or equal to 0 and less than 65536');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isPort($value);
	}

	private static function isPort($value)
	{
		return $value <= 65535;
	}
}
