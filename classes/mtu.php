<?php

namespace estvoyage\net;

use
	estvoyage\data,
	estvoyage\value
;

final class mtu extends value\integer\unsigned
{
	function __construct($value)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\exception $domainException) {}

		if ($domainException || ! self::isMtu($value))
		{
			throw new mtu\exception\domain('MTU should be an integer greater than or equal to 68');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isMtu($value);
	}

	private static function isMtu($value)
	{
		return $value >= 68;
	}
}
