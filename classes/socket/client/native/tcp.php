<?php

namespace estvoyage\net\socket\client\native;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\error,
	estvoyage\data
;

final class tcp extends socket
{
	function __construct(host $host, port $port, data\consumer\controller $controller = null)
	{
		parent::__construct($host, $port, 'tcp', $controller);
	}
}
