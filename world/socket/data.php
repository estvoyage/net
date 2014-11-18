<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface data extends net\string
{
	function successfullySentTo(net\socket $socket, net\host $host, net\port $port);
	function failToSentTo(net\socket $socket, net\host $host, net\port $port, net\byte\number $bytes);
}
