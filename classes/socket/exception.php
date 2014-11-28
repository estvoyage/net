<?php

namespace estvoyage\net\socket;

use
	estvoyage\value,
	estvoyage\net\world as net,
	estvoyage\net\world\socket\logger,
	estvoyage\net\socket\error
;

final class exception extends \exception implements net\exception
{
	use value\immutable;

	function __construct(error $error)
	{
		parent::__construct($error->message->asString, $error->code->asInteger);

		$this->values = [ 'code' => $error->code, 'message' => $error->message ];
	}
}
