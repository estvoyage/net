<?php

namespace estvoyage\net\world\endpoint;

use
	estvoyage\net\world as net
;

interface socket extends net\endpoint
{
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
