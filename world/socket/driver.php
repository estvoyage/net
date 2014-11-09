<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface driver
{
	function connectTo($host, $port);
	function writeData($data, callable $dataRemaining);
	function write(data $data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
