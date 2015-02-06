<?php

namespace estvoyage\net\socket\buffer;

use
	estvoyage\net,
	estvoyage\net\world\socket
;

final class write
{
	private
		$socket,
		$writer
	;

	function __construct(net\socket $socket, socket\writer $writer)
	{
		$this->socket = $socket;
		$this->writer = $writer;
	}

	function newData(net\socket\data $data)
	{
		$dataLength = strlen($data);

		if (($bytesWritten = socket_send($this->socket->socket, $data, $dataLength, 0)) === false)
		{
			throw new net\socket\exception(new net\socket\error(new net\socket\error\code(socket_last_error($this->socket))));
		}

		if ($bytesWritten < $dataLength)
		{
			$this->writer->remainingDataInSocketBufferAre(new net\socket\data(substr($data, $bytesWritten)));
		}

		return $this;
	}
}
