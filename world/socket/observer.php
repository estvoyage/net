<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface observer
{
	function dataSent($data, $host, $port, net\socket $socket);
	function dataNotFullySent($data, $bytesWritten, $host, $port, net\socket $socket);
	function dataNotSent($data, $errno, $host, $port, net\socket $socket);
}
