<?php

namespace estvoyage\net\world;

interface socket
{
	function write($data, $host, $port, socket\observer $observer);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
