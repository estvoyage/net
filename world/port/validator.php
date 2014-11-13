<?php

namespace estvoyage\net\world\port;

interface validator
{
	function validate($value, callable $ok, callable $ko = null);
}
