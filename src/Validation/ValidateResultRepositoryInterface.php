<?php

namespace Opifer\QueueIt\Validation;

interface ValidateResultRepositoryInterface
{
    public function getValidationResult($queue);
    public function setValidationResult($queue, $validationResult);
}
