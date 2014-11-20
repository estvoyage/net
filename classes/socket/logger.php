<?php

namespace estvoyage\net\socket;

use
	estvoyage\net\world\socket\logger\media
;

class logger
{
	private
		$dataSentFormat,
		$dataNotFullySentFormat,
		$dataNotSentFormat,
		$observer,
		$media
	;

	function __construct($dataSentFormat, $dataNotFullySentFormat, $dataNotSentFormat, media $media, media\observer $observer)
	{
		$this->dataSentFormat = $dataSentFormat;
		$this->dataNotFullySentFormat = $dataNotFullySentFormat;
		$this->dataNotSentFormat = $dataNotSentFormat;
		$this->media = $media;
		$this->observer = $observer;
	}

	function logDataSentOnSocket($host, $port, $data, $id)
	{
		! $this->dataSentFormat ?: $this->media->store(sprintf($this->dataSentFormat, $host, $port, $data, $id), $this->observer);

		return $this;
	}
}
