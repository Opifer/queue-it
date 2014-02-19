<?php

namespace Opifer\QueueIt;

interface IKnownUser
{
	public function getQueueId();
	public function getPlaceInQueue();
	public function getTimeStamp();
	public function getCustomerId();
	public function getEventId();
	public function getOriginalUrl();
}
