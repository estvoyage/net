<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class connection implements net\connection
{
	private
		$socket
	;

	function __construct(net\address $address, net\endpoint\socket\protocol $protocol)
	{
		$address->connect(new endpoint\socket($protocol), function($socket) {
				$this->socket = $socket;
			}
		);
	}

	function write($data, callable $dataRemaining)
	{
		$this->socket->write($data, $dataRemaining);

		return $this;
	}
}
