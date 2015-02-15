<?php

namespace estvoyage\net\socket\client\native;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\error
;

final class udp extends socket
{
	protected function connectToHostAndPort(host $host, port $port)
	{
		return $this->openStream('udp://' . $host, $port);
	}
}
