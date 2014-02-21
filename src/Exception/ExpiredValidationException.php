<?php

namespace Opifer\QueueIt\Exception;

class ExpiredValidationException extends SessionValidationException
{
	private $knownUser;
	
	/**
	 * Constructor
	 *
	 * @param  QueueInterface      $queue
	 * @param  KnownUserInterface  $knownUser
	 */
	public function __construct($queue, $knownUser)
	{
		parent::__construct('Known User token is expired', null, $queue);
		
		$this->knownUser = $knownUser;
	}
	
	/** 
	 * Get known user
	 * 
	 * @return  KnownUserInterface
	 */
	function getKnownUser()
	{
		return $this->knownUser;
	}
}
