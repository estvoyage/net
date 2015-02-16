<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\error
;

final class udp extends socket
{
	protected function connectToHostAndPort(host $host, port $port)
	{
		$resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP);

		if (! $resource)
		{
			throw new exception;
		}

		return $this->connectResourceToHostAndPort($resource, $host, $port);
	}
}
