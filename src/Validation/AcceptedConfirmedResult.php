<?php

namespace Opifer\QueueIt\Validation;

use Opifer\QueueIt\Validation\ValidateResultBase;

class AcceptedConfirmedResult extends ValidateResultBase
{
	private $initialRequest;
	private $knownUser;
	
	public function __construct($queue, $knownUser, $initialRequest)
	{
		parent::__construct($queue);
		
		$this->knownUser = $knownUser;
		$this->initialRequest = $initialRequest;
	}
	
	function isInitialValidationRequest()
	{
		return $this->initialRequest;
	}
	
	function getKnownUser()
	{
		return $this->knownUser;
	}
}
