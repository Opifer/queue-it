<?php

namespace Opifer\QueueIt\Validation;

class ValidateResultBase implements ValidateResultInterface
{
	private $queue;
	
	function getQueue()
	{
		return $this->queue;
	}
	
	public function __construct($queue)
	{
		$this->queue = $queue;		
	}
}
