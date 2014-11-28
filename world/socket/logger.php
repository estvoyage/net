<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\socket\error
;

interface logger
{
	function write(error\code $code, error\message $message);
}
