<?php

namespace Opifer\QueueIt;

interface IKnownUserUrlProvider
{
	public function GetUrl();
	public function getQueueId($queryStringPrefix);
	public function getPlaceInQueue($queryStringPrefix);
	public function getTimeStamp($queryStringPrefix);
	public function getEventId($queryStringPrefix);
	public function getCustomerId($queryStringPrefix);
	public function getOriginalUrl($queryStringPrefix);
	public function getRedirectType($queryStringPrefix);
}
