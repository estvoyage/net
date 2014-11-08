<?php

namespace estvoyage\net\world;

interface socket
{
	function connectTo(host $host, port $port);
	function write(socket\data $data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
