<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port
;

abstract class socket extends net\socket\client\socket
{
	function buildWriteBufferFor(net\socket\client\writer $writer)
	{
		return new writeBuffer($this, $writer);
	}

	protected function isConnected($resource)
	{
		return is_resource($resource);
	}

	protected function disconnect($resource)
	{
		socket_close($resource);
	}
}
