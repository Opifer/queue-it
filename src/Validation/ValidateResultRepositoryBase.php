<?php

namespace Opifer\QueueIt\Validation;

abstract class ValidateResultRepositoryBase implements ValidateResultRepositoryInterface
{
	private $sessionQueueId = "QueueITAccepted-SDFrts345E-";

    /**
     * Generate key
     *
     * @param   string  $customerId
     * @param   string  $eventId
     *
     * @return  string
     */
	protected function generateKey($customerId, $eventId)
	{
		return $this->sessionQueueId . $customerId . "-" . $eventId;
	}
}
