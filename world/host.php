<?php

namespace estvoyage\net\world;

interface host
{
	function openSocket(socket $socket, port $port);
}
