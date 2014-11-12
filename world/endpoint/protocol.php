<?php

namespace estvoyage\net\world\endpoint;

interface protocol
{
	function connect($host, $port);
	function connectHost($host);
	function connectPort($port);
	function write($data, callable $dataRemaining);
	function disconnect();
}
