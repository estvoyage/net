<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\data
;

abstract class socket extends net\socket\client\socket
{
	private
		$domain,
		$type,
		$protocol,
		$resource
	;

	function __construct(host $host, port $port, $domain, $type, $protocol, data\consumer\controller $controller = null)
	{
		parent::__construct($host, $port, $controller);

		$this->domain = $domain;
		$this->type = $type;
		$this->protocol = $protocol;
	}

	final function __clone()
	{
		$this->resource = null;
	}

	final protected function connectToHostAndPort(host $host, port $port)
	{
		if (! $this->resource)
		{
			switch (true)
			{
				case ! ($resource = socket_create($this->domain, $this->type, $this->protocol));
				case ! socket_connect($resource, $host, $port->asInteger):
					throw $this->exception();
			}

			$this->resource = $resource;
		}
	}

	final protected function disconnect()
	{
		if ($this->resource)
		{
			socket_close($this->resource);

			$this->resource = null;
		}
	}

	final protected function writeData(data\data $data)
	{
		$bytesWritten = socket_send($this->resource, $data, strlen($data), 0);

		if ($bytesWritten === false)
		{
			throw $this->exception();
		}

		$this->numberOfBytesConsumedIs(new data\data\numberOfBytes($bytesWritten));
	}

	private function exception()
	{
		$errorCode = socket_last_error($this->resource);

		return new net\socket\exception(socket_strerror($errorCode), $errorCode);
	}
}
