<?php

namespace estvoyage\net\endpoint\socket;

use
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

	function writeOn(socket\protocol $protocol)
	{
		$data = $this->data;

		try
		{
			while ($data)
			{
				$protocol->writeData($data, function($dataRemaining) use (& $data) { $data = $dataRemaining; });
			}
		}
		catch (\exception $exception)
		{
			throw new data\exception($exception->getMessage());
		}

		return $this;
	}
}
