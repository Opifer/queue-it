<?php

namespace Opifer\QueueIt;

interface IValidateResultRepository
{
	public function getValidationResult($queue);
	public function setValidationResult($queue, $validationResult);
}
