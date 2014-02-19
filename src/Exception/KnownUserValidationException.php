<?php

namespace Opifer\QueueIt\Exception;

class KnownUserValidationException extends SessionValidationException
{
	public function __construct($previous, $queue)
	{
		parent::__construct($previous->message, $previous, $queue);
	}
}
