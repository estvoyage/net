<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world as net
;

interface address
{
	function connectSocket(net\socket $socket);
}
