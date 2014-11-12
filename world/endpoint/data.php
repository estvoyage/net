<?php

namespace estvoyage\net\world\endpoint;

interface data
{
	function writeOn(protocol $protocol, $host, $port);
}
