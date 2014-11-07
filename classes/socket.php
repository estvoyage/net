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

	function shutdown()
	{
		$socket = clone $this;
		$socket->driver = $this->driver->shutdown();

		return $socket;
	}

	function shutdownOnlyReading()
	{
		$socket = clone $this;
		$socket->driver = $this->driver->shutdownOnlyReading();

		return $socket;
	}

	function shutdownOnlyWriting()
	{
		$socket = clone $this;
		$socket->driver = $this->driver->shutdownOnlyWriting();

		return $socket;
	}

	function disconnect()
	{
		$socket = clone $this;
		$socket->driver = $this->driver->disconnect();

		return $socket;
	}
}
