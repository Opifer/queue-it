<?php

namespace Opifer\QueueIt\Exception;

class SessionValidationException extends \Exception
{
	private $queue;
	
	function __construct($message, $previous, $queue)
	{
		parent::__construct($message, null, $previous);
		
		$this->queue = $queue;
	}

	function getQueue()
	{
		return $this->queue;
	}
}
