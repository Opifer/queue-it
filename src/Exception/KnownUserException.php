<?php

namespace Opifer\QueueIt\Exception;

class KnownUserException extends \Exception
{
	private $originalUrl;
	private $validationUrl;
	
	public function setOriginalUrl($value)
	{
		$this->originalUrl = $value;
	}

	public function setValidationUrl($value)
	{
		$this->validationUrl = $value;
	}
	
	public function getOriginalUrl()
	{		
		return $this->originalUrl;
	}
	
	public function getValidationUrl()
	{
		return $this->validationUrl;
	}
}
