<?php

namespace Opifer\QueueIt\Validation;

class ValidateResultBase implements ValidateResultInterface
{
	/**
	 * @var  Queue
	 */
	private $queue;
	
	/**
	 * Constructor
	 *
	 * @param  Opifer\QueueIt\Queue\Queue  $queue
	 */
	public function __construct($queue)
	{
		$this->queue = $queue;		
	}
	
	/**
	 * Get Queue
	 *
	 * @return  Opifer\QueueIt\Queue\Queue
	 */
	function getQueue()
	{
		return $this->queue;
	}
}
