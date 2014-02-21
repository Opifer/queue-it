<?php

namespace Opifer\QueueIt\Exception;

class KnownUserException extends \Exception
{
	/**
	 * @var  string
	 */
	private $originalUrl;

	/**
	 * @var  string
	 */
	private $validationUrl;
	
	/**
	 * Set original URL
	 *
	 * @param   string  $value
	 *
	 * @return  string
	 */
	public function setOriginalUrl($value)
	{
		$this->originalUrl = $value;

		return $this;
	}

	/**
	 * Set validation URL
	 *
	 * @param   string  $value
	 *
	 * @return  string
	 */
	public function setValidationUrl($value)
	{
		$this->validationUrl = $value;

		return $this;
	}
	
	/**
	 * Get original URL
	 *
	 * @return  string
	 */
	public function getOriginalUrl()
	{		
		return $this->originalUrl;
	}
	
	/**
	 * Get validation URL
	 *
	 * @return  string
	 */
	public function getValidationUrl()
	{
		return $this->validationUrl;
	}
}
