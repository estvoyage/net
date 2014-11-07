<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../runner.php';

use
	estvoyage\net\tests\units,
	estvoyage\net\socket,
	estvoyage\net\socket\driver
;

class udp extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\socket')
		;
	}
}
