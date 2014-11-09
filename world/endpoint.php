<?php

namespace estvoyage\net\world;

interface endpoint
{
	function connectHost($host);
	function connectPort($port);
}
