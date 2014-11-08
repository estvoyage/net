<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface data
{
	function __toString();
	function remove($bytes);
	function writeOn(net\socket\driver $driver);
}
