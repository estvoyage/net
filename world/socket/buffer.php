<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\socket\data
;

interface buffer
{
	function dataWasNotSent(data $data);
}
