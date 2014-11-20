<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class address extends units\test
{
	function testClass()
	{
		$this->testedClass
			->implements('estvoyage\net\world\address')
		;
	}

	function testSend()
	{
		$this
			->given(
				$observer = new net\socket\observer,
				$socket = new net\socket,
				$host = uniqid(),
				$port = uniqid(),
				$id = uniqid(),
				$data = uniqid(),
				$this->newTestedInstance($host, $port)
			)

			->if(
				$this->calling($socket)->write = function($data, $host, $port, $observer, $id) { $observer->dataSentOnSocket($data, $id, $this); }
			)
			->then
				->object($this->testedInstance->send($data, $socket, $observer, $id))->isTestedInstance
				->mock($socket)->call('write')->withIdenticalArguments($data, $host, $port, $observer, $id)->once
				->mock($observer)->call('dataSentOnSocket')->withIdenticalArguments($data, $id, $socket)->once

			->if(
				$this->calling($socket)->write = function($data, $host, $port, $observer, $id) use (& $bytesWritten) { $observer->dataNotFullySentOnSocket($data, $bytesWritten = rand(1, PHP_INT_MAX), $id, $this); }
			)
			->then
				->object($this->testedInstance->send($data, $socket, $observer, $id))->isTestedInstance
				->mock($socket)->call('write')->withIdenticalArguments($data, $host, $port, $observer, $id)->twice
				->mock($observer)->call('dataNotFullySentOnSocket')->withIdenticalArguments($data, $bytesWritten, $id, $socket)->once
		;
	}
}
