<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class socket implements net\socket
{
	private
		$driver
	;

	function __construct(net\socket\driver $driver)
	{
		$this->driver = $driver;
	}

	function connectHost($host)
	{
		$socket = clone $this;
		$socket->driver = $this->driver->connectHost($host);

		return $this;
	}

	function connectPort($port)
	{
		$socket = clone $this;
		$socket->driver = $this->driver->connectPort($port);

		return $this;
	}

	function write(net\socket\data $data)
	{
		try
		{
			$data->writeOn($this->driver);
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
