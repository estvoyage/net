<?php

namespace estvoyage\net\world\endpoint;

interface protocol
{
	function write($data, $host, $port, callable $dataRemaining);
	function disconnect();
}
