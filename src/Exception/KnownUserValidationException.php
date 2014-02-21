<?php

namespace Opifer\QueueIt\Exception;

class KnownUserValidationException extends SessionValidationException
{
    /**
     * Constructor
     *
     * @param  Exception  $previous
     * @param  Queue      $queue
     */
	public function __construct($previous, $queue)
	{
		parent::__construct($previous->message, $previous, $queue);
	}
}
