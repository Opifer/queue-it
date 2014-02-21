<?php

namespace Opifer\QueueIt\Validation;

class EnqueueResult extends ValidateResultBase
{
	private $redirectUrl;
	
	/**
	 * Constructor
	 *
	 * @param  Queue   $queue
	 * @param  string  $redirectUrl
	 */
	public function __construct($queue, $redirectUrl)
	{
		parent::__construct($queue);
		
		$this->redirectUrl = $redirectUrl;
	}
	
	/**
	 * Get redirect URL
	 *
	 * @return  string
	 */
	function getRedirectUrl()
	{
		return $this->redirectUrl;
	}
}
