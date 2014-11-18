<?php

namespace estvoyage\net;

use
	estvoyage\net\world as net
;

class string implements net\string
{
	function __construct($value)
	{
		$previousErrorHandler = set_error_handler(function($errno, $errstr, $errfile, $errline, $errcontext) use (& $previousErrorHandler) {
				restore_error_handler();

				switch ($errno)
				{
					case E_RECOVERABLE_ERROR:
							throw new string\exception('Value can not be converted to string');

					default:
						return $previousErrorHandler ? $previousErrorHandler($errno, $errstr, $errfile, $errline, $errcontext) : false;
				}
			}
		);

		$this->value = (string) $value;

		restore_error_handler();
	}

	function __toString()
	{
		return $this->value;
	}
}
