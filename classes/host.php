<?php

namespace estvoyage\net;

use
	estvoyage\value\world as value
;

final class host
{
	use value\string {
		validate as isString;
	}

	static function validate($value)
	{
		switch (true)
		{
			case ! self::isString($value):
			case $value === '':
			case ! preg_match('#^(?:[a-z0-9][-a-z0-9]{0,62}\.)*[a-z0-9][-a-z0-9]{0,62}(?<!-)\.?$#i', $value):
			case strlen(rtrim($value, '.')) > 253:
				return false;

			default:
				return true;
		}
	}
}
