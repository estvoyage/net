<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port
;

final class tcp extends socket
{
	protected function connectToHostAndPort(host $host, port $port)
	{
		$resource = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);

		if (! $resource)
		{
			throw new net\socket\client\sockets\exception;
		}

		return $this->connectResourceToHostAndPort($resource, $host, $port);
	}
}
