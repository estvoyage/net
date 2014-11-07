<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world as net
;

interface socket
{
	function connectTo($host, $port);
	function write($data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
