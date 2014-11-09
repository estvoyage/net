<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world as net
;

interface address
{
	function connectTo(net\endpoint $endpoint);
}
