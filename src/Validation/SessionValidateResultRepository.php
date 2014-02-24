<?php

namespace Opifer\QueueIt\Validation;

class SessionValidateResultRepository extends ValidateResultRepositoryBase
{
	/**
	 * Get validation result
	 *
	 * @param   Opifer\QueueIt\Queue\Queue  $queue
	 *
	 * @return  string
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
	 * @param   Opifer\QueueIt\Queue\Queue  					   $queue
	 * @param   Opifer\QueueIt\Validation\AcceptedConfirmedResult  $validationResult
	 *
	 * @return  void
	 */
	public function setValidationResult($queue, $validationResult)
	{
		if ($validationResult instanceof AcceptedConfirmedResult) {
			$key = $this->generateKey($queue->getCustomerId(), $queue->getEventId());
			$_SESSION[$key] = $validationResult;
		}
	}
}
