<?php

namespace estvoyage\net\endpoint\socket;

use
	estvoyage\net\world\endpoint,
	estvoyage\net\world\endpoint\socket
;

class data implements socket\data
{
	private
		$data
	;

	function __construct($data = '')
	{
		$this->data = $data;
	}

	function writeOn(endpoint\protocol $protocol, $host, $port)
	{
		$data = $this->data;

		try
		{
			while ($data)
			{
				$protocol->write($data, $host, $port, function($dataRemaining) use (& $data) { $data = $dataRemaining; });
			}
		}
		catch (\exception $exception)
		{
			throw new data\exception($exception->getMessage());
		}

		return $this;
	}
}
