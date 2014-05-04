<?php

namespace Opifer\QueueIt\Exception;

class SessionValidationException extends \Exception
{
    /**
     * @var  Opifer\QueueIt\Queue\Queue
     */
    private $queue;

    /**
     * Constructor
     *
     * @param string                     $message
     * @param Exception                  $previous
     * @param Opifer\QueueIt\Queue\Queue $queue
     */
    public function __construct($message, $previous, $queue)
    {
        parent::__construct($message, null, $previous);

        $this->queue = $queue;
    }

    /**
     * Get queue
     *
     * @return Opifer\QueueIt\Queue\Queue
     */
    public function getQueue()
    {
        return $this->queue;
    }
}
