<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface observer
{
	function dataSent($data, $id, net\socket $socket);
	function dataNotFullySent($data, $bytesWritten, $id, net\socket $socket);
	function dataNotSent($data, $errno, $id, net\socket $socket);
}
