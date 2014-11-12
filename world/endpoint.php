<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world\endpoint
;

interface endpoint
{
	function connectHost($host);
	function connectPort($port);
	function write($data, callable $dataRemaining);
}
