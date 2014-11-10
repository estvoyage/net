<?php

namespace estvoyage\net\world\endpoint;

interface protocol
{
	function connectHost($host);
	function connectPort($port);
	function write($data, callable $dataRemaining);
	function disconnect();
}
