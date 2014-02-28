<?php

namespace Opifer\QueueIt\Queue;

use InvalidArgumentException;
use Opifer\QueueIt\Exception\ConfigurationErrorsException;
use Opifer\QueueIt\Identifier\Identifier;

class QueueFactory
{
	private static $domain;	
	
	/**
	 * Reset
	 *
	 * @return  void
	 */
	static function reset()
	{
		global $domain;
		
		$domain = "queue-it.net";
	}
	
	/**
	 * Configure
	 *
	 * @param   string  $hostDomain
	 *
	 * @return  void
	 */
	static function configure($hostDomain = null)
	{
		global $domain;
		
		if ($hostDomain != null)
			$domain = $hostDomain;
	}
	
	/**
	 * Create a queue from configuration
	 *
	 * @param   string  $queueName
	 *
	 * @throws  InvalidArgumentException
	 * @throws  Opifer\QueueIt\Exception\ConfigurationErrorsException
	 *
	 * @return  Opifer\QueueIt\Queue\Queue
	 */
	static function createQueueFromConfiguration($queueName = 'default')
	{
		if ($queueName == null)
			throw new InvalidArgumentException('Queue Name cannot be null or empty');
		
		$iniFileName = $_SERVER['DOCUMENT_ROOT'] . "/../queueit.ini";
		
		if (!file_exists($iniFileName))
			throw new ConfigurationErrorsException('Configuration file "' . $iniFileName . '" is missing');
		
		$settings_array = parse_ini_file($iniFileName, true);
		
		if (!$settings_array)
			throw new ConfigurationErrorsException('Configuration file "' . $iniFileName . '" is invalid');
		
		$queue = $settings_array[$queueName];
		
		if ($queue == null)
			throw new ConfigurationErrorsException('Configuration for Queue Name "' . $queueName . '" in file "' . $iniFileName . '" is missing from configuration file');
		
		return QueueFactory::instantiateQueue(
			$queue['customerId'], 
			$queue['eventId'], 
			isset($queue['domainAlias']) ? $queue['domainAlias'] : null, 
			isset($queue['landingPage']) ? $queue['landingPage'] : null, 
			isset($queue['useSsl']) && $queue['useSsl'] == 1 ? true : false, 
			isset($queue['includeTargetUrl']) && $queue['includeTargetUrl'] == 1 ? true : false,
			isset($queue['language']) ? $queue['language'] : null, 
			isset($queue['layoutName']) ? $queue['layoutName'] : null
		);		
	}
	
	/**
	 * Create a queue
	 *
	 * @param   string  $customerId
	 * @param   string  $eventId
	 *
	 * @return  Opifer\QueueIt\Queue\Queue
	 */
	static function createQueue($customerId, $eventId)
	{
		return QueueFactory::instantiateQueue($customerId, $eventId, null, null, false, false, null, null);
	}
	
	/**
	 * Instantiate the queue
	 *
	 * @param   string   $customerId
	 * @param   string   $eventId
	 * @param   string   $domainAlias
	 * @param   string   $landingPage
	 * @param   boolean  $sslEnabled
	 * @param   boolean  $includeTargetUrl
	 * @param   string   $language
	 * @param   string   $layoutName
	 *
	 * @return  Opifer\QueueIt\Queue\Queue
	 */
	private static function instantiateQueue($customerId, $eventId, $domainAlias, $landingPage, $sslEnabled, $includeTargetUrl, $language, $layoutName)
	{
		global $domain;
		
		$customerId = strtolower($customerId);
		$eventId = strtolower($eventId);
				
		if ($domainAlias == null)
			$domainAlias = $eventId . '-' . $customerId . '.' . $domain;
			
		return new Queue(
			$customerId, 
			$eventId, 
			$domainAlias, 
			$landingPage, 
			$sslEnabled, 
			$includeTargetUrl,
			$language,
			$layoutName
		);
	}
}

QueueFactory::reset(true);
