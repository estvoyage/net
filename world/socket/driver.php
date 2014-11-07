<?php

namespace estvoyage\net\world\socket;

interface driver
{
	function connectTo($host, $port);
	function write($data);
	function disconnect();
}
