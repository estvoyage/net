<?php

namespace estvoyage\net\world\address;

use
	estvoyage\net\world as net
;

interface socket
{
	function write($data, $host, $port, callable $dataNotWritten);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
