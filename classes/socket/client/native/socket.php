<?php

namespace estvoyage\net\socket\client\native;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\data
;

abstract class socket extends net\socket\client\socket
{
	private
		$resource,
		$protocol
	;

	function __construct(host $host, port $port, $protocol, data\consumer\controller $controller = null)
	{
		parent::__construct($host, $port, $controller);

		$this->protocol = $protocol;
	}

	function __clone()
	{
		$this->resource = null;
	}

	final protected function connectToHostAndPort(host $host, port $port)
	{
		if (! $this->resource)
		{
			$resource = @fsockopen($this->protocol . '://' . $host, $port->asInteger, $errno, $errstr);

			if (! $resource)
			{
				throw new net\socket\exception($errstr, $errno);
			}

			$this->resource = $resource;
		}
	}

	final protected function writeData(data\data $data)
	{
		$previousErrorHandler = set_error_handler(function($errno, $errstr) use (& $exceptionMessage) {
				$exceptionMessage = $errstr;
			}
		);

		$bytesWritten = @fwrite($this->resource, $data, strlen($data));

		set_error_handler($previousErrorHandler);

		if ($exceptionMessage)
		{
			$exceptionCode = 0;

			if (preg_match('/ errno=(\d+) /', $exceptionMessage, $matches))
			{
				$exceptionCode = $matches[1];
			}

			throw new net\socket\exception($exceptionMessage, $exceptionCode);
		}

		$this->numberOfBytesConsumedIs(new data\data\numberOfBytes($bytesWritten));
	}

	final protected function disconnect()
	{
		if ($this->resource)
		{
			@fclose($this->resource);

			$this->resource = null;
		}
	}
}
