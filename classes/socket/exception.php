<?php

namespace estvoyage\net\socket;

use
	estvoyage\value\world as value,
	estvoyage\net,
	estvoyage\net\socket\error
;

final class exception extends net\exception
{
	use value\immutable;

	function __construct(error $error)
	{
		parent::__construct($error->message->asString, $error->code->asInteger);

		$this->init([ 'code' => $error->code, 'message' => $error->message ]);
	}
}
