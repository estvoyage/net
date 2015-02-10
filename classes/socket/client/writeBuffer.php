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
			$data = new net\socket\data(substr($data, $this->bytesOfDataWrittenOnSocket($data, $this->socket)->asInteger) ?: '');
		}

		return $this;
	}

	protected abstract function bytesOfDataWrittenOnSocket(net\socket\data $data, net\socket\client\socket $socket);
}
