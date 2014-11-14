<?php

namespace estvoyage\net\endpoint\socket;

use
	estvoyage\net\world as net
;

class data implements net\endpoint\socket\data
{
	private
		$data
	;

	function __construct($data = '')
	{
		$this->data = $data;
	}

	function writeOn(net\endpoint $endpoint)
	{
		$data = $this->data;

		try
		{
			while ($data)
			{
				$endpoint->write($data, function($dataRemaining) use (& $data) { $data = $dataRemaining; });
			}
		}
		catch (\exception $exception)
		{
			throw new data\exception($exception->getMessage());
		}

		return $this;
	}
}
