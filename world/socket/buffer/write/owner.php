<?php

namespace estvoyage\net\world\socket\buffer\write;

use
	estvoyage\net\socket
;

interface owner
{
	function remainingDataInSocketBufferAre(socket\data $data);
}
