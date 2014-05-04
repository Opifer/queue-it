<?php

namespace Opifer\QueueIt\KnownUser;

use Opifer\QueueIt\Identifier\Identifier;

class DefaultKnownUserUrlProvider implements KnownUserUrlProviderInterface
{
    /**
     * Get URL
     *
     * @return string
     */
    public function getUrl()
    {
        $identifier = new Identifier;

        return $identifier->currentUrl();
    }

    /**
     * Get Queue ID
     *
     * @param string $queryStringPrefix
     *
     * @return string
     */
    public function getQueueId($queryStringPrefix)
    {
        $key = $queryStringPrefix . "q";

        return $this->getVar($key);
    }

    /**
     * Get Place-in-queue prefix
     *
     * @param string $queryStringPrefix
     *
     * @return string
     */
    public function getPlaceInQueue($queryStringPrefix)
    {
        $key = $queryStringPrefix . "p";

        return $this->getVar($key);
    }

    /**
     * Get timestamp
     *
     * @param string $queryStringPrefix
     *
     * @return [type]
     */
    public function getTimeStamp($queryStringPrefix)
    {
        $key = $queryStringPrefix . "ts";

        return $this->getVar($key);
    }

    /**
     * Get event ID
     *
     * @param string $queryStringPrefix
     *
     * @return string
     */
    public function getEventId($queryStringPrefix)
    {
        $key = $queryStringPrefix . "e";

        return $this->getVar($key);
    }

    /**
     * Get customer ID
     *
     * @param string $queryStringPrefix
     *
     * @return [type]
     */
    public function getCustomerId($queryStringPrefix)
    {
        $key = $queryStringPrefix . "c";

        return $this->getVar($key);
    }

    /**
     * Get redirect type
     *
     * @param string $queryStringPrefix
     *
     * @return string
     */
    public function getRedirectType($queryStringPrefix)
    {
        $key = $queryStringPrefix . "rt";

        return $this->getVar($key);
    }

    /**
     * Get original URL
     *
     * @param string $queryStringPrefix
     *
     * @return string
     */
    public function getOriginalUrl($queryStringPrefix)
    {
        $url = $this->getUrl();

        $url = preg_replace("/([\?&])(" . $queryStringPrefix . "q=[^&]*&?)/i", "$1", $url);
        $url = preg_replace("/([\?&])(" . $queryStringPrefix . "p=[^&]*&?)/i", "$1", $url);
        $url = preg_replace("/([\?&])(" . $queryStringPrefix . "ts=[^&]*&?)/i", "$1", $url);
        $url = preg_replace("/([\?&])(" . $queryStringPrefix . "c=[^&]*&?)/i", "$1", $url);
        $url = preg_replace("/([\?&])(" . $queryStringPrefix . "e=[^&]*&?)/i", "$1", $url);
        $url = preg_replace("/([\?&])(" . $queryStringPrefix . "rt=[^&]*&?)/i", "$1", $url);
        $url = preg_replace("/([\?&])(" . $queryStringPrefix . "h=[^&]*&?)/i", "$1", $url);
        $url = preg_replace("/[\?&]$/", "", $url);

        return $url;
    }

    /**
     * Get var
     *
     * @param string $key
     *
     * @return mixed
     */
    private function getVar($key)
    {
        if (!isset($_GET[$key]))
            return null;

        return $_GET[$key];
    }
}
