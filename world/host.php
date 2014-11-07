<?php

namespace estvoyage\net\world;

interface host
{
	function connectSocket(socket $socket, port $port);
}
