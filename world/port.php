<?php

namespace estvoyage\net\world;

interface port
{
	function openSocket(socket $socket, $host);
}
