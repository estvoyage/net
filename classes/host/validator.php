<?php

namespace estvoyage\net\host;

use
	estvoyage\net\world as net
;

class validator implements net\host\validator
{
	function validate($value, callable $ok, callable $ko = null)
	{
		preg_match('/^[0-9a-z][0-9a-z-]{0,62}(?:\.[0-9a-z-]{1,63}){0,3}$/i', $value) ? $ok($value) : $ko ? $ko($value) : null;

		return $this;
	}
}
