<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world\endpoint
;

interface endpoint
{
	function connect(endpoint\address\component $component);
	function connectHost($host);
	function connectPort($port);
}
