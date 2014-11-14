<?php

namespace estvoyage\net\world\address;

interface validator
{
	function validate($host, $port, callable $ok, callable $ko = null);
}
