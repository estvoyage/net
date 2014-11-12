<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world as net
;

interface connection
{
	function write($data, callable $dataRemaining);
}
