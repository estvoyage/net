<?php

namespace estvoyage\net\world;

use
	estvoyage\net\socket\data,
	estvoyage\net\address
;

interface socket
{
	function write(data $data, address $address);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
