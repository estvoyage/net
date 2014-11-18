<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\world as net
;

interface data extends net\string
{
	function sentTo(net\socket $socket, net\host $host, net\port $port);
	function notFullySentTo(net\socket $socket, net\host $host, net\port $port, data\offset $start, data\offset $stop);
	function notSentTo(net\socket $socket, net\host $host, net\port $port, data\offset $start, net\socket\error $error);
}
