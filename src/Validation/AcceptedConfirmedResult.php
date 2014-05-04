<?php

namespace Opifer\QueueIt\Validation;

class AcceptedConfirmedResult extends ValidateResultBase
{
    /**
     * @var  boolean
     */
    private $initialRequest;

    /**
     * @var  Opifer\QueueIt\KnownUser\KnownUserInterface
     */
    private $knownUser;

    /**
     * Constructor
     *
     * @param Opifer\QueueIt\Queue\QueueInterface         $queue
     * @param Opifer\QueueIt\KnownUser\KnownUserInterface $knownUser
     * @param boolean                                     $initialRequest
     */
    public function __construct($queue, $knownUser, $initialRequest)
    {
        parent::__construct($queue);

        $this->knownUser = $knownUser;
        $this->initialRequest = $initialRequest;
    }

    /**
     * Is initial validation request
     *
     * @return boolean
     */
    public function isInitialValidationRequest()
    {
        return $this->initialRequest;
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
