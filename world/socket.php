<?php

namespace estvoyage\net\world;

use
	estvoyage\net\socket\data
;

interface socket
{
	function bufferContains(socket\buffer $buffer, data $data);
}
