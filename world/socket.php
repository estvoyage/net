<?php

namespace estvoyage\net\world;

interface socket
{
	function connectTo($host, $port);
	function write($data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
