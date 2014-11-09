<?php

namespace estvoyage\net\host;

use
	estvoyage\net\host
;

class localhost extends host
{
	function __construct()
	{
		parent::__construct('127.0.0.1');
	}
}
