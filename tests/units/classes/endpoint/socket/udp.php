<?php

namespace estvoyage\net\tests\units\endpoint\socket;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\endpoint\socket
;

class udp extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\endpoint\socket')
		;
	}
}
