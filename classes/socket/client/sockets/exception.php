<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net
;

class exception extends net\socket\exception
{
	function __construct($socket = null)
	{
		$errorCode = $socket ? socket_last_error($socket) : socket_last_error();

		if (! $errorCode)
		{
			throw new \logicException('No socket error occured');
		}

		$errorMessage = socket_strerror($errorCode);

		parent::__construct($errorMessage, $errorCode);
	}
}
