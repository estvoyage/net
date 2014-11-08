<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface driver
{
	function connectTo(net\host $host, net\port $port);
	function write(data $data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
