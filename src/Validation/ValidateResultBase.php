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
	 * @param  Queue  $queue
	 */
	public function __construct($queue)
	{
		$this->queue = $queue;		
	}
	
	/**
	 * Get Queue
	 *
	 * @return  Queue
	 */
	function getQueue()
	{
		return $this->queue;
	}
}
