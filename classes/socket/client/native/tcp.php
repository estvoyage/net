<?php

namespace estvoyage\net\socket\client\native;

use
	estvoyage\net,
	estvoyage\net\host,
	estvoyage\net\port,
	estvoyage\net\socket\error
;

final class tcp extends socket
{
	protected function connectToHostAndPort(host $host, port $port)
	{
		return $this->openStream('tcp://' . $host, $port);
	}
}
