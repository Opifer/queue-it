<?php

namespace Opifer\QueueIt;

//use ValidateResultBase;

class AcceptedConfirmedResult extends ValidateResultBase
{
	private $initialRequest;
	private $knownUser;
	
	function isInitialValidationRequest()
	{
		return $this->initialRequest;
	}
	
	function getKnownUser()
	{
		return $this->knownUser;
	}
	
	public function __construct($queue, $knownUser, $initialRequest)
	{
		parent::__construct($queue);
		$this->knownUser = $knownUser;
		$this->initialRequest = $initialRequest;
	}
}