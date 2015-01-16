<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\socket\data
;

interface buffer
{
	function remainingData(data $data);
}
