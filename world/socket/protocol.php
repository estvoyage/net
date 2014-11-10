<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface protocol
{
	function connectHost($host);
	function connectPort($port);
	function writeData($data, callable $dataRemaining);
	function write(data $data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
