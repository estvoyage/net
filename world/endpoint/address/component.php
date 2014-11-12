<?php

namespace estvoyage\net\world\endpoint\address;

use
	estvoyage\net\world as net
;

interface component
{
	function connect(net\endpoint $endpoint, callable $callback);
}
