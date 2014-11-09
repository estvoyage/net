<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world as net
;

class data implements net\socket\data
{
	private
		$data
	;

	function __construct($data = '')
	{
		$this->data = $data;
	}

	function writeOn(net\socket\driver $driver)
	{
		$data = $this->data;

		try
		{
			while ($data)
			{
				$driver->writeData($data, function($dataRemaining) use (& $data) { $data = $dataRemaining; });
			}
		}
		catch (\exception $exception)
		{
			throw new data\exception($exception->getMessage());
		}

		return $this;
	}
}
