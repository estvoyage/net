<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface data
{
	function writeOn(net\socket\protocol $protocol);
}
