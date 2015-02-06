<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net,
	estvoyage\net\host,
	estvoyage\net\port
;

abstract class socket
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

		if ($this->isConnected($resource))
		{
			$this->disconnect($resource);
		}
	}

	function __clone()
	{
		$this->initResource();
	}

	function __get($property)
	{
		$property = $this->getValueOfProperty($property);

		if (! $this->isConnected($property))
		{
			$this->initResource($property = $this->connectToHostAndPort($this->host, $this->port));
		}

		return $property;
	}

	abstract function buildWriteBufferFor(net\socket\writer $writer);

	abstract protected function isConnected($resource);
	abstract protected function connectToHostAndPort(host $host, port $port);
	abstract protected function disconnect($resource);

	private function initResource($resource = null)
	{
		return $this->init([ 'resource' => $resource ]);
	}
}
