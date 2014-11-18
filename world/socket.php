<?php

namespace estvoyage\net\world;

interface socket
{
	function write($data, $host, $port, callable $dataNotWritten);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
