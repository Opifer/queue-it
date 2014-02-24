<?php

namespace Opifer\QueueIt\Validation;

class EnqueueResult extends ValidateResultBase
{
	/**
	 * @var  string
	 */
	private $redirectUrl;
	
	/**
	 * Constructor
	 *
	 * @param  Opifer\QueueIt\Queue\Queue   $queue
	 * @param  string  						$redirectUrl
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
