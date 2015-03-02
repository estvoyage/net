<?php

namespace estvoyage\net\tests\units;

require __DIR__ . '/../runner.php';

use
	estvoyage\net\mtu as testedClass,
	estvoyage\data,
	mock\estvoyage\data as mockedData
;

class mtu extends test
{
	function testClass()
	{
		$this->testedClass
			->extends('estvoyage\value\integer\unsigned')
			->implements('estvoyage\data\splitter')
			->isFinal
		;
	}

	function testDataForDataConsumerUseDelimiter()
	{
		$this
			->given(
				$dataConsumer = new mockedData\consumer,
				$delimiter = new mockedData\data\delimiter,
				$this->newTestedInstance(68)
			)
			->if(
				$data = new data\data(str_repeat('0', 68))
			)
			->then
				->object($this->testedInstance->dataForDataConsumerUseDataDelimiter($data, $dataConsumer, $delimiter))->isTestedInstance
				->mock($dataConsumer)
					->receive('newData')
						->withArguments($data)->once

			->if(
				$data = new data\data(str_repeat('1', 69)),
				$this->calling($delimiter)->dataSplitterNeedDelimitedDataFromData[1] = function($dataSplitter, $data) {
					$dataSplitter->noDelimiterInData($data);
				}
			)
			->then
				->exception(function()
						use (
							$data,
							$dataConsumer,
							$delimiter
						) {
						$this->testedInstance->dataForDataConsumerUseDataDelimiter($data, $dataConsumer, $delimiter);
					}
				)
					->isInstanceOf('estvoyage\net\mtu\overflow')
					->hasMessage('Unable to split data according to MTU 68')

			->if(
				$data = new data\data(str_repeat('2', 68) . '3'),

				$this->calling($delimiter)->dataSplitterNeedDelimitedDataFromData[2] = function($dataSplitter, $data) {
					$dataSplitter->delimitedDataIs(new data\data(str_repeat('2', 68)));
				},

				$this->testedInstance->dataForDataConsumerUseDataDelimiter($data, $dataConsumer, $delimiter)
			)
			->then
				->mock($dataConsumer)
					->receive('newData')
						->withArguments(new data\data(str_repeat('2', 68)))->once
						->withArguments(new data\data('3'))->once
		;
	}
}
