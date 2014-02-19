<?php

namespace Opifer\QueueIt\Queue;

interface QueueInterface
{
	public function getEventId();
	public function getCustomerId();
	public function getQueueUrl($targetUrl = null, $sslEnabled = null, $domainAlias = null, $language = null, $layoutName = null);
	public function getCancelUrl($landingPage = null, $queueId = null, $sslEnabled = null, $domainAlias = null);
	public function getLandingPageUrl($targetUrl = null);
}
