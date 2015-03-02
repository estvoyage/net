<?php

namespace estvoyage\net;

use
	estvoyage\data,
	estvoyage\value
;

final class mtu extends value\integer\unsigned implements data\splitter
{
	private
		$data,
		$dataConsumer
	;

	function __construct($value)
	{
		$domainException = null;

		try
		{
			parent::__construct($value);
		}
		catch (\exception $domainException) {}

		if ($domainException || ! self::isMtu($value))
		{
			throw new \domainException('MTU should be an integer greater than or equal to 68');
		}
	}

	function noDelimiterInData(data\data $data)
	{
		$this->ifData(function() use ($data) {
				throw new mtu\overflow('Unable to split data according to MTU ' . $this);
			}
		);

		return $this;
	}

	function delimitedDataIs(data\data $data)
	{
		$this->ifData(function() use ($data) {
				$this->data = substr($this->data, strlen($data));
				$this->dataConsumer->newData($data);
			}
		);

		return $this;
	}

	function dataForDataConsumerUseDataDelimiter(data\data $data, data\consumer $dataConsumer, data\data\delimiter $delimiter)
	{
		$this
			->newDataForDataConsumer($data, $dataConsumer)
			->useDelimiter($delimiter)
		;

		return $this;
	}

	static function validate($value)
	{
		return parent::validate($value) && self::isMtu($value);
	}

	private function newDataForDataConsumer(data\data $data, data\consumer $dataConsumer)
	{
		$splitter = new self($this->asInteger);
		$splitter->data = (string) $data;
		$splitter->dataConsumer = $dataConsumer;

		return $splitter;
	}

	private function useDelimiter(data\data\delimiter $delimiter)
	{
		while (strlen($this->data) > $this->asInteger)
		{
			$delimiter->dataSplitterNeedDelimitedDataFromData($this, new data\data(substr($this->data, 0, $this->asInteger)));
		}

		$this->dataConsumer->newData(new data\data($this->data));

		return $this;
	}

	private function ifData(callable $callable)
	{
		if ($this->data)
		{
			$callable();
		}
	}

	private static function isMtu($value)
	{
		return $value >= 68;
	}
}
