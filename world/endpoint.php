<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world\endpoint
;

interface endpoint
{
	function write($data, $host, $port, callable $dataRemaining);
}
