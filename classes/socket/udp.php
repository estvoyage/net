<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world as net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\data,
	estvoyage\net\socket\error
;

class udp
{
	private
		$host,
		$port
	;

	use \estvoyage\value\world\immutable {
		__get as private getValueOfProperty;
	}

	function __construct(host $host, port $port)
	{
		$this->host = $host;
		$this->port = $port;

		$this->initResource();
	}

	function __destruct()
	{
		$resource = $this->getValueOfProperty('resource');

		if (is_resource($resource))
		{
			socket_close($resource);

			$this->initResource();
		}
	}

	function __clone()
	{
		$this->initResource();
	}

	function __get($property)
	{
		$property = $this->getValueOfProperty($property);

		if (! is_resource($property))
		{
			$this->initResource($property = $this->createResource());
		}

		return $property;
	}

	private function initResource($resource = null)
	{
		return $this->init([ 'resource' => $resource ]);
	}

	private function createResource()
	{
		switch (true)
		{
			case ! ($resource = socket_create(AF_INET, SOCK_DGRAM, SOL_UDP)):
			case ! socket_connect($resource, $this->host, $this->port->asInteger):
				throw new exception(new error(new error\code(socket_last_error($resource))));

			default:
				return $resource;
		}
	}
}
