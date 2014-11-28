<?php

namespace estvoyage\net;

use
	estvoyage\value
;

trait immutable
{
	function __get($property)
	{
		try
		{
			return parent::__get($property);
		}
		catch (\logicException $exception)
		{
			throw new \logicException('Undefined property: ' . get_class($this) . '::' . $property);
		}
	}

	function __set($property, $value)
	{
		try
		{
			parent::__set($property, $value);
		}
		catch (\logicException $exception)
		{
			throw new \logicException(get_class($this) . ' is immutable');
		}
	}

	function __unset($property)
	{
		try
		{
			parent::__unset($property);
		}
		catch (\logicException $exception)
		{
			throw new \logicException(get_class($this) . ' is immutable');
		}
	}
}
