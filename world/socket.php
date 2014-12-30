<?php

namespace estvoyage\net\world;

use
	estvoyage\net\world as net,
	estvoyage\net\socket\data,
	estvoyage\net\address
;

interface socket
{
	function shouldSend(data $data, net\socket\buffer $buffer);
	function mustSend(data $data);
	function noMoreDataToSend();
	function noMoreDataToReceive();
	function noMoreDataToSendOrReceive();
	function isNowUseless();
}
