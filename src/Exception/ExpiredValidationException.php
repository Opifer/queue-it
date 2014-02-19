<?php

namespace Opifer\QueueIt\Exception;

class ExpiredValidationException extends SessionValidationException
{
	private $knownUser;
	
	public function __construct($queue, $knownUser)
	{
		parent::__construct('Known User token is expired', null, $queue);
		
		$this->knownUser = $knownUser;
	}
	
	function getKnownUser()
	{
		return $this->knownUser;
	}
}
