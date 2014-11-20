<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class connection extends units\test
{
	function testSend()
	{
		$this
			->given(
				$address = new net\address,
				$socket = new net\socket,
				$observer = new net\socket\observer,
				$id = uniqid(),
				$data = uniqid(),
				$this->newTestedInstance($address, $socket, $observer)
			)

			->if(
				$this->calling($address)->send = function($data, $socket, $observer, $id) { $observer->dataSentOnSocket($data, $id, $socket); }
			)
			->then
				->object($this->testedInstance->send($data, $id))->isTestedInstance
				->mock($address)->call('send')->withIdenticalArguments($data, $socket, $observer, $id)->once
				->mock($observer)->call('dataSentOnSocket')->withIdenticalArguments($data, $id, $socket)->once

			->if(
				$this->calling($address)->send = function($data, $socket, $observer, $id) use (& $bytesWritten) { $observer->dataNotFullySentOnSocket($data, $bytesWritten = rand(1, PHP_INT_MAX), $id, $socket); }
			)
			->then
				->object($this->testedInstance->send($data, $id))->isTestedInstance
				->mock($address)->call('send')->withIdenticalArguments($data, $socket, $observer, $id)->twice
				->mock($observer)->call('dataNotFullySentOnSocket')->withIdenticalArguments($data, $bytesWritten, $id, $socket)->once
		;
	}
}
