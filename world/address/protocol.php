<?php

namespace estvoyage\net\world\endpoint;

interface protocol
{
	function write($data, callable $dataRemaining);
	function disconnect();
}
