<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface observer
{
	function dataSentOnSocket($data, $id, net\socket $socket);
	function dataNotFullySentOnSocket($data, $bytesWritten, $id, net\socket $socket);
	function dataNotSentOnSocket($data, $errno, $id, net\socket $socket);
}
