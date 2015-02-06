<?php

namespace estvoyage\net\world\socket;

use
	estvoyage\net\socket
;

interface writer
{
	function remainingDataInSocketBufferAre(socket\data $data);
}
