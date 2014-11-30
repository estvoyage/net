<?php

namespace estvoyage\net\tests\units\mock\socket;

class error
{
	public
		$code,
		$message
	;
}

@class_alias(__NAMESPACE__ . '\error', 'estvoyage\net\socket\error');
