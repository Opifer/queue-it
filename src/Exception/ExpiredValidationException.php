<?php

namespace Opifer\QueueIt\Exception;

class ExpiredValidationException extends SessionValidationException
{
    private $knownUser;

    /**
     * Constructor
     *
     * @param Opifer\QueueIt\Queue\QueueInterface         $queue
     * @param Opifer\QueueIt\KnownUser\KnownUserInterface $knownUser
     */
    public function __construct($queue, $knownUser)
    {
        parent::__construct('Known User token is expired', null, $queue);

        $this->knownUser = $knownUser;
    }

    /**
     * Get known user
     *
     * @return Opifer\QueueIt\KnownUser\KnownUserInterface
     */
    public function getKnownUser()
    {
        return $this->knownUser;
    }
}
