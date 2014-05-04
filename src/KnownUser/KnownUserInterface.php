<?php

namespace Opifer\QueueIt\KnownUser;

interface KnownUserInterface
{
    public function getQueueId();
    public function getPlaceInQueue();
    public function getTimeStamp();
    public function getCustomerId();
    public function getEventId();
    public function getOriginalUrl();
}
