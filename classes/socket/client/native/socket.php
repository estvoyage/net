<?php

namespace estvoyage\net\socket\client\native;

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
		@fclose($resource);
	}

	final protected function openStream($host, $port)
	{
		$resource = @fsockopen($host, $port->asInteger, $errno, $errstr);

		if (! $resource)
		{
			throw new net\socket\exception($errstr, $errno);
		}

		return $resource;
	}
}
