<?php

namespace estvoyage\net\socket\client\native;

use
	estvoyage\net
;

final class writeBuffer extends net\socket\client\writeBuffer
{
	protected function bytesOfDataWrittenOnSocket(net\socket\data $data, net\socket\client\socket $socket)
	{
		$previousErrorHandler = set_error_handler(function($errno, $errstr) use (& $exceptionMessage) {
				$exceptionMessage = $errstr;
			}
		);

		$bytesWritten = fwrite($socket->resource, $data, strlen($data), 0);

		set_error_handler($previousErrorHandler);

		if ($exceptionMessage)
		{
			$exceptionCode = 0;

			if (preg_match('/ errno=(\d+) /', $exceptionMessage, $matches))
			{
				$exceptionCode = $matches[1];
			}

			throw new net\socket\exception($exceptionMessage, $exceptionCode);
		}

		return new net\socket\data\byte($bytesWritten);
	}
}
