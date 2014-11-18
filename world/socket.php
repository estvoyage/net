<?php

namespace estvoyage\net\world;

interface socket
{
	function write(socket\data $data, host $host, port $port);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
