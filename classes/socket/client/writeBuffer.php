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

	function __construct(net\socket\client\socket $socket, net\socket\client\writer $writer)
	{
		$this->socket = $socket;
		$this->writer = $writer;
	}

	function newData(net\socket\data $data)
	{
		if (($bytesWritten = $this->sendDataOnSocket($data, $this->socket)) < strlen($data))
		{
			$this->writer->remainingDataInSocketBufferAre(new net\socket\data(substr($data, $bytesWritten)));
		}

		return $this;
	}

	protected abstract function sendDataOnSocket(net\socket\data $data, net\socket\client\socket $socket);
}
