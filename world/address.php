<?php

namespace estvoyage\net\world;

interface address
{
	function send($data, socket $socket, socket\observer $observer, $id = null);
}
