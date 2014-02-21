<?php

namespace Opifer\QueueIt\Validation;

class AcceptedConfirmedResult extends ValidateResultBase
{
	private $initialRequest;
	private $knownUser;
	
	/**
	 * Constructor
	 *
	 * @param  QueueInterface      $queue
	 * @param  KnownUserInterface  $knownUser
	 * @param  [type]              $initialRequest
	 */
	public function __construct($queue, $knownUser, $initialRequest)
	{
		parent::__construct($queue);
		
		$this->knownUser = $knownUser;
		$this->initialRequest = $initialRequest;
	}
	
	/**
	 * Is initial validation request
	 *
	 * @return  boolean //?
	 */
	function isInitialValidationRequest()
	{
		return $this->initialRequest;
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
