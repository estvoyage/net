<?php

namespace estvoyage\net\world;

use
	estvoyage\net\socket\data,
	estvoyage\net\address
;

interface socket
{
	function write(data $data);
	function writeAll(data $data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
