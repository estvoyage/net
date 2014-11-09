<?php

namespace estvoyage\net\world;

interface socket extends endpoint
{
	function connectHost($host);
	function connectPort($port);
	function writeData($data, callable $dataRemaining);
	function write(socket\data $data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
