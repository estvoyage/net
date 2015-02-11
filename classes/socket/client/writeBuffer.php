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
		while ((string) $data)
		{
			$data = $data->shift($this->bytesOfDataWrittenOnSocket($data, $this->socket));
		}

		return $this;
	}

	protected abstract function bytesOfDataWrittenOnSocket(net\socket\data $data, net\socket\client\socket $socket);
}
