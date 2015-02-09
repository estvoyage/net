<?php

namespace estvoyage\net;

use
	estvoyage\value
;

final class host extends value\string
{
	function __construct($value)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\domainException $domainException) {}

		if ($domainException || ! self::isHost($value))
		{
			throw new \domainException('Value is not a valid host');
		}
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isHost($value);
	}

	private static function isHost($value)
	{
		switch (true)
		{
			case $value === '':
			case ! preg_match('#^(?:[a-z0-9][-a-z0-9]{0,62}\.)*[a-z0-9][-a-z0-9]{0,62}(?<!-)\.?$#i', $value):
			case strlen(rtrim($value, '.')) > 253:
				return false;

			default:
				return true;
		}
	}
}
