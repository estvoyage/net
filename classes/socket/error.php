<?php

namespace estvoyage\net\socket;

use
	estvoyage\value,
	estvoyage\net,
	estvoyage\net\socket\error\code,
	estvoyage\net\socket\error\message
;

final class error extends value\generic
{
	use net\immutable;

	function __construct(code $code)
	{
		parent::__construct([ 'code' => $code, 'message' => new message(socket_strerror($code->asInteger)) ]);
	}
}
