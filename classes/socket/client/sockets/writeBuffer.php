<?php

namespace estvoyage\net\socket\client\sockets;

use
	estvoyage\net
;

final class writeBuffer extends net\socket\client\writeBuffer
{
	protected function bytesOfDataWrittenOnSocket(net\socket\data $data, net\socket\client\socket $socket)
	{
		$bytesWritten = socket_send($socket->resource, $data, strlen($data), 0);

		if ($bytesWritten === false)
		{
			throw new net\socket\client\sockets\exception($socket);
		}

		return new net\socket\data\byte($bytesWritten);
	}
}
