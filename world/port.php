<?php

namespace estvoyage\net\world;

interface port
{
	function connectSocket(socket $socket, $host);
}
