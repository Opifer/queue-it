<?php

namespace Opifer\QueueIt\Queue;

use Opifer\QueueIt\Identifier\Identifier;

class Queue implements QueueInterface
{
	private $customerId;
	private $eventId;
	private $safetynetImageUrl;
	private $defaultDomainAlias;
	private $defaultQueueUrl;
	private $defaultCancelUrl;
	private $defaultLandingPageUrl;
	private $defaultIncludeTargetUrl;
	private $defaultSslEnabled;
	private $defaultLanguage;
	private $defaultLayoutName;
	
	/**
	 * Constructor
	 *
	 * @param  string   $customerId
	 * @param  string   $eventId
	 * @param  string   $domainAlias
	 * @param  string   $landingPage
	 * @param  boolean  $sslEnabled
	 * @param  boolean  $includeTargetUrl
	 * @param  string   $language
	 * @param  string   $layoutName
	 */
	public function __construct($customerId, $eventId, $domainAlias, $landingPage, $sslEnabled, $includeTargetUrl, $language, $layoutName)
	{	
		$this->customerId = $customerId;
		$this->eventId = $eventId;
		$this->defaultQueueUrl = $this->generateQueueUrl($sslEnabled, $domainAlias, $language, $layoutName);
		$this->defaultCancelUrl = $this->generateCancelUrl($sslEnabled, $domainAlias, $language, $layoutName);
		$this->safetynetImageUrl = '//' . $domainAlias . '/queue/' . $customerId . '/' . $eventId . '/safetynetimage';
		$this->defaultDomainAlias = $domainAlias;
		$this->defaultLandingPageUrl = $landingPage;
		$this->defaultSslEnabled = $sslEnabled;
		$this->defaultIncludeTargetUrl = $includeTargetUrl;
		$this->defaultLanguage = $language;
		$this->defaultLayoutName = $layoutName;
	}
	
	/**
	 * @return  string
	 */
	public function getEventId()
	{
		return $this->eventId;
	}

	/**
	 * @return  string
	 */
	public function getCustomerId()
	{
		return $this->customerId;		
	}

	/**
	 * Get queue URL
	 *
	 * @param   string   $targetUrl
	 * @param   boolean  $sslEnabled
	 * @param   stromg   $domainAlias
	 * @param   stromg   $language
	 * @param   stromg   $layoutName
	 *
	 * @return  string
	 */
	public function getQueueUrl($targetUrl = null, $sslEnabled = null, $domainAlias = null, $language = null, $layoutName = null)
	{	
		$queueUrl = $this->getQueueUrlWithoutTarget($sslEnabled, $domainAlias, $language, $layoutName);
		
		$queueUrl = $this->includeTargetUrl($targetUrl, $queueUrl);
		
		return $queueUrl;
	}

	/**
	 * Get the cancel URL
	 *
	 * @param   string   $landingPage
	 * @param   [type]   $queueId
	 * @param   boolean  $sslEnabled
	 * @param   string   $domainAlias
	 *
	 * @return  string
	 */
	public function getCancelUrl($landingPage = null, $queueId = null, $sslEnabled = null, $domainAlias = null)
	{	
		$url = $domainAlias != null
			? $this->generateCancelUrl($sslEnabled, $domainAlias)
			: $this->defaultCancelUrl;
				
		if ($sslEnabled) {
			$url = str_replace('http://', 'https://', $url);
		} else if ($sslEnabled != null) {
			$url = str_replace('https://', 'http://', $url);
		}
				
		if ($queueId != null)
			$url = $url . '&q=' . $queueId;
		
		if ($landingPage != null)
			$url = $url . '&r=' . urlencode($landingPage);

		if ($landingPage == null && $this->defaultLandingPageUrl != null)
			$url = $url . '&r=' . urlencode($this->defaultLandingPageUrl);
		
		return $url;
	}
	
	/**
	 * Get landing page URL
	 *
	 * @param   string  $targetUrl
	 *
	 * @return  string
	 */
	public function getLandingPageUrl($targetUrl = null)
	{
		if ($this->defaultLandingPageUrl == null)
			return null;
		
		if (!$targetUrl && !$this->defaultIncludeTargetUrl)
			return $this->defaultLandingPageUrl;
		
		return $this->includeTargetUrl($targetUrl, $this->defaultLandingPageUrl);	
	}
	
	/**
	 * Gets the queue URL without target
	 *
	 * @param   boolean  $sslEnabled
	 * @param   string   $domainAlias
	 * @param   string   $language
	 * @param   string   $layoutName
	 *
	 * @return  string
	 */
	private function getQueueUrlWithoutTarget($sslEnabled, $domainAlias, $language, $layoutName)
	{
		$url = $domainAlias != null || $language != null || $layoutName != null
			? $this->generateQueueUrl($sslEnabled, $domainAlias, $language, $layoutName)
			: $this->defaultQueueUrl;
		
		if ($sslEnabled) {
			$url = str_replace('http://', 'https://', $url);
		} else if ($sslEnabled != null) {
			$url = str_replace('https://', 'http://', $url);
		}
		
		return $url;
	}
	
	/**
	 * Include target URL
	 *
	 * @param   string  $targetUrl
	 * @param   string  $queueUrl
	 *
	 * @return  string
	 */
	private function includeTargetUrl($targetUrl, $queueUrl)
	{
		$queueUrl = preg_replace("/(&?t=[^&]*&?)/i", "", $queueUrl);
		
		if ($targetUrl == null)
			$targetUrl = $this->defaultIncludeTargetUrl;
		
		if (is_bool($targetUrl) && $targetUrl == true) {
			$identifier = new Identifier();
			$targetUrl = $identifier->currentUrl();
		}
		
		if (is_bool($targetUrl) && $targetUrl == false)
			return $queueUrl;
			
		if (!strpos($queueUrl, '?'))
			return $queueUrl . '?t=' . urlencode($targetUrl);
		
		return $queueUrl . '&t=' . urlencode($targetUrl);
	}
	
	/**
	 * Generate queue URL
	 *
	 * @param   boolean  $sslEnabled
	 * @param   string   $domainAlias
	 * @param   string   $language
	 * @param   string   $layoutName
	 *
	 * @return  string
	 */
	private function generateQueueUrl($sslEnabled, $domainAlias, $language, $layoutName)
	{
		if ($domainAlias == null)
			$domainAlias = $this->defaultDomainAlias;

		$protocol = $sslEnabled ? 'https://' : 'http://';
		
		$url = $protocol . $domainAlias . '/?c=' . $this->customerId . '&e=' . $this->eventId;
			
		if ($language != null)
			$url = $url . '&cid=' . $language;
		
		if ($layoutName != null)
			$url = $url . '&l=' . urlencode($layoutName);
		
		return $url;
	}
	
	/**
	 * Generate cancel URL
	 *
	 * @param   boolean  $sslEnabled
	 * @param   string   $domainAlias
	 *
	 * @return  string
	 */
	private function generateCancelUrl($sslEnabled, $domainAlias)
	{
		if ($domainAlias == null)
			$domainAlias = $this->defaultDomainAlias;
	
		$protocol = $sslEnabled ? 'https://' : 'http://';
	
		return $protocol . $domainAlias . '/cancel.aspx?c=' . $this->customerId . '&e=' . $this->eventId;
	}
}
