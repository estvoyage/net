<?php

namespace estvoyage\net\world\host;

interface validator
{
	function validate($value, callable $ok, callable $ko = null);
}
