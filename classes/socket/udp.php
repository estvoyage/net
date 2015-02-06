<?php

namespace estvoyage\net\socket;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\error,
	estvoyage\net\world\socket
;

final class udp extends net\socket
{
	function buildWriteBufferFor(socket\writer $writer)
	{
		return new net\socket\writeBuffer($this, $writer);
	}

	protected function isConnected($resource)
	{
		return is_resource($resource);
	}

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

	protected function disconnect($resource)
	{
		socket_close($resource);
	}
}
