<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port
;

abstract class socket extends net\socket\client\socket
{
	function buildWriteBuffer()
	{
		return new writeBuffer($this);
	}

	protected function isConnected($resource)
	{
		return is_resource($resource);
	}

	protected function disconnect($resource)
	{
		socket_close($resource);
	}

	protected function connectResourceToHostAndPort($resource, host $host, port $port)
	{
		if (! socket_connect($resource, $host, $port->asInteger))
		{
			throw new exception($resource);
		}

		return $resource;
	}
}
