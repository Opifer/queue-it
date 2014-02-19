<?php

namespace Opifer\QueueIt\Validation;

interface IValidateResultRepository
{
	public function getValidationResult($queue);
	public function setValidationResult($queue, $validationResult);
}
