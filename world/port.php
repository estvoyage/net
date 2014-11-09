<?php

namespace estvoyage\net\world;

interface port
{
	function connectTo(endpoint $endpoint);
}
