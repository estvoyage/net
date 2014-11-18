<?php

namespace estvoyage\net\world;

interface endpoint
{
	function send(socket\data $data);
}
