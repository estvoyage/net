<?php

namespace estvoyage\net\tests\units\socket;

require __DIR__ . '/../../../runner.php';

use
	estvoyage\net\tests\units,
	mock\estvoyage\net\world as net
;

class logger extends units\test
{
	function testLogDataSentOnSocket()
	{
		$this
			->given(
				$media = new net\socket\logger\media,
				$observer = new net\socket\logger\media\observer,
				$host = uniqid(),
				$port = uniqid(),
				$data = uniqid(),
				$id = uniqid(),
				$format = '%1$s,%2$s,%3$s,%4$s'
			)
			->if(
				$this->newTestedInstance('', '', '', $media, $observer)
			)
			->then
				->object($this->testedInstance->logDataSentOnSocket($host, $port, $data, $id))->isTestedInstance
				->mock($media)->call('store')->never

			->if(
				$this->newTestedInstance($format, '', '', $media, $observer)
			)
			->then
				->object($this->testedInstance->logDataSentOnSocket($host, $port, $data, $id))->isTestedInstance
				->mock($media)->call('store')->withIdenticalArguments(sprintf($format, $host, $port, $data, $id), $observer)->once
		;
	}
}
