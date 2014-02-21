<?php

namespace Opifer\QueueIt\Validation;

class SessionValidateResultRepository extends ValidateResultRepositoryBase
{
	/**
	 * Get validation result
	 *
	 * @param   Queue  $queue
	 *
	 * @return  [type]
	 */
	public function getValidationResult($queue)
	{		
		$key = $this->generateKey($queue->getCustomerId(), $queue->getEventId());

		if (!isset($_SESSION[$key]))
			return null;
		
		$result = $_SESSION[$key];
		
		return $result;
	}
	
	/**
	 * Set validation result
	 *
	 * @param  Queue  $queue
	 * @param  [type]  $validationResult
	 */
	public function setValidationResult($queue, $validationResult)
	{
		if ($result instanceof AcceptedConfirmedResult) {
			$key = $this->generateKey($queue->getCustomerId(), $queue->getEventId());
			$_SESSION[$key] = $validationResult;
		}		
	}
}
