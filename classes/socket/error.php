<?php

namespace estvoyage\net\socket;

use
	estvoyage\value\world as value,
	estvoyage\net\socket\error\code,
	estvoyage\net\socket\error\message
;

final class error
{
	use value\immutable;

	function __construct(code $code)
	{
		$this->init([ 'code' => $code, 'message' => new message(socket_strerror($code->asInteger)) ]);
	}
}
