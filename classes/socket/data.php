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

	function __toString()
	{
		return $this->data;
	}

	function remove($bytes)
	{
		$data = $this;

		if ($data->data)
		{
			$data = clone $this;
			$data->data = substr($data->data, $bytes) ?: '';
		}

		return $data;
	}

	function writeOn(net\socket\driver $driver)
	{
		if ($this->data)
		{
			try
			{
				$data = $driver->write($this);

				while ($data->data)
				{
					$data = $driver->write($data);
				}
			}
			catch (\exception $exception)
			{
				throw new data\exception($exception->getMessage());
			}
		}

		return $this;
	}
}
