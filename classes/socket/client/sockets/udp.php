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
		switch (true)
		{
			case ! ($resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)):
			case ! socket_connect($resource, $host, $port->asInteger):
				throw new exception(new error(new error\code(socket_last_error($resource))));

			default:
				return $resource;
		}
	}
}
