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

	function __construct(callable $dataNotFullySent, callable $dataNotSent, callable $dataSent)
	{
		$this->dataSent = $dataSent;
		$this->dataNotFullySent = $dataNotFullySent;
		$this->dataNotSent = $dataNotSent;
	}

	function dataSentOnSocket($data, $id, socket $socket)
	{
		call_user_func_array($this->dataSent, func_get_args());

		return $this;
	}

	function dataNotFullySentOnSocket($data, $bytesWritten, $id, socket $socket)
	{
		call_user_func_array($this->dataNotFullySent, func_get_args());

		return $this;
	}

	function dataNotSentOnSocket($data, $errno, $id, socket $socket)
	{
		call_user_func_array($this->dataNotSent, func_get_args());

		return $this;
	}
}
