<?php

namespace estvoyage\net\world\endpoint\socket;

interface protocol
{
	function connectHost($host);
	function connectPort($port);
	function writeData($data, callable $dataRemaining);
	function write(data $data);
	function shutdown();
	function shutdownOnlyReading();
	function shutdownOnlyWriting();
	function disconnect();
}
