<?php

namespace estvoyage\net\socket\client;

use
	estvoyage\net
;

abstract class writeBuffer
{
	private
		$socket,
		$writer
	;

	function __construct(net\socket\client\socket $socket)
	{
		$this->socket = $socket;
	}

	function newData(net\socket\data $data)
	{
		$dataLength = strlen($data);

		while ($dataLength)
		{
			$bytesWritten = $this->sendDataOnSocket($data, $this->socket);

			if ($bytesWritten > 0)
			{
				$data = new net\socket\data(substr($data, $bytesWritten) ?: '');

				$dataLength -= $bytesWritten;
			}
		}

		return $this;
	}

	protected abstract function sendDataOnSocket(net\socket\data $data, net\socket\client\socket $socket);
}
