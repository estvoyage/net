<?php

namespace estvoyage\net\socket;

use
	estvoyage\value
;

final class data extends value\string
{
	function shift(data\byte $byte)
	{
		return ! $byte->asInteger || ! $this->asString ? $this : new self(substr($this, $byte->asInteger) ?: '');
	}
}
