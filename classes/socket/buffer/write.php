<?php

namespace estvoyage\net\socket\buffer;

use
	estvoyage\net,
	estvoyage\net\world\socket\buffer
;

final class write
{
	private
		$socket,
		$owner
	;

	function __construct(net\socket $socket, buffer\write\owner $owner)
	{
		$this->socket = $socket;
		$this->owner = $owner;
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
			$this->owner->remainingDataInSocketBufferAre(new net\socket\data(substr($data, $bytesWritten)));
		}

		return $this;
	}
}
