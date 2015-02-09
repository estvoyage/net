<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net
;

final class writeBuffer extends net\socket\client\writeBuffer
{
	function __construct(socket $socket, net\socket\client\writer $writer)
	{
		parent::__construct($socket, $writer);
	}

	protected function sendDataOnSocket(net\socket\data $data, net\socket\client\socket $socket)
	{
		$dataLength = strlen($data);

		if (($bytesWritten = socket_send($socket->socket, $data, $dataLength, 0)) === false)
		{
			throw new net\socket\exception(new net\socket\error(new net\socket\error\code(socket_last_error($socket->socket))));
		}

		return $bytesWritten;
	}
}
