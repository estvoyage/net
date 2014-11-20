<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world\socket
;

class observer implements socket\observer
{
	private
		$dataSent,
		$dataNotFullySent
	;

	function __construct(callable $dataSent, callable $dataNotFullySent, callable $dataNotSent)
	{
		$this->dataSent = $dataSent;
		$this->dataNotFullySent = $dataNotFullySent;
		$this->dataNotSent = $dataNotSent;
	}

	function dataSent($data, $id, socket $socket)
	{
		call_user_func_array($this->dataSent, func_get_args());

		return $this;
	}

	function dataNotFullySent($data, $bytesWritten, $id, socket $socket)
	{
		call_user_func_array($this->dataNotFullySent, func_get_args());

		return $this;
	}

	function dataNotSent($data, $errno, $id, socket $socket)
	{
		call_user_func_array($this->dataNotSent, func_get_args());

		return $this;
	}
}
