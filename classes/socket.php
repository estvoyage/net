<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class socket
{
	private
		$driver
	;

	function __construct(net\socket\driver $driver)
	{
		$this->driver = $driver;
	}

	function connectTo($host, $port)
	{
		$socket = clone $this;
		$socket->driver = $this->driver->connectTo($host, $port);

		return $socket;
	}

	function write($data)
	{
		try
		{
			$this->driver->write(new socket\data($data));
		}
		catch (\exception $exception)
		{
			throw new socket\exception($exception->getMessage());
		}

		return $this;
	}
}
