<?php

namespace estvoyage\net\world\endpoint;

use
	estvoyage\net\world as net
;

interface address
{
	function send(net\socket\data $data, net\socket $socket);
}
