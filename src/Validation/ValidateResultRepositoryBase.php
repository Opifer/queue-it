<?php

namespace Opifer\QueueIt\Validation;

abstract class ValidateResultRepositoryBase implements ValidateResultRepositoryInterface
{
	private $sessionQueueId = "QueueITAccepted-SDFrts345E-";

	protected function generateKey($customerId, $eventId)
	{
		return $this->sessionQueueId . $customerId . "-" . $eventId;
	}
}
