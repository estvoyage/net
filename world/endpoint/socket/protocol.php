<?php

namespace estvoyage\net\world\endpoint\socket;

use
	estvoyage\net\world\endpoint
;

interface protocol extends endpoint\protocol
{
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
}
