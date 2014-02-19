<?php

namespace Opifer\QueueIt\Validation;

class EnqueueResult extends ValidateResultBase
{
	private $redirectUrl;
	
	public function __construct($queue, $redirectUrl)
	{
		parent::__construct($queue);
		
		$this->redirectUrl = $redirectUrl;
	}
	
	function getRedirectUrl()
	{
		return $this->redirectUrl;
	}
}
