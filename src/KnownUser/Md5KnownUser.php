<?php

namespace Opifer\QueueIt\KnownUser;

class Md5KnownUser implements KnownUserInterface
{
    private $queueId;
    private $placeInQueue;
    private $timeStamp;
    private $customerId;
    private $eventId;
    private $url;
    private $originalUrl;

    public function __construct($queueId, $placeInQueue, $timestamp, $customerId, $eventId, $redirectType, $originalUrl)
    {
        $this->queueId = $queueId;
        $this->placeInQueue = $placeInQueue;
        $this->timeStamp = $timestamp;
        $this->customerId = $customerId;
        $this->eventId = $eventId;
        $this->redirectType = $redirectType;
        $this->originalUrl = $originalUrl;
    }

    public function getQueueId()
    {
        return $this->queueId;
    }

    /**
     * Get number of place in queue
     *
     * @return integer
     */
    public function getPlaceInQueue()
    {
        if ($this->placeInQueue == 9999999 || $this->placeInQueue <= 0)
            return null;

        return $this->placeInQueue;
    }

    public function getTimeStamp()
    {
        return $this->timeStamp;
    }

    public function getCustomerId()
    {
        return $this->customerId;
    }

    public function getEventId()
    {
        return $this->eventId;
    }

    public function getRedirectType()
    {
        return $this->redirectType;
    }

    public function getOriginalUrl()
    {
        return $this->originalUrl;
    }
}
