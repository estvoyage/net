<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\socket\data
;

interface buffer
{
	function newData(data $data);
	function remainingData(data $data);
}
