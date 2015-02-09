<?php

namespace estvoyage\net\socket\client;

use
	estvoyage\net
;

interface writer
{
	function remainingDataInSocketBufferAre(net\socket\data $data);
}
