<?php

namespace Opifer\QueueIt\Queue;

interface QueueInterface
{
    /**
     * @return string
     */
    public function getEventId();

    /**
     * @return string
     */
    public function getCustomerId();

    /**
     * Get queue URL
     *
     * @param string  $targetUrl
     * @param boolean $sslEnabled
     * @param stromg  $domainAlias
     * @param stromg  $language
     * @param stromg  $layoutName
     *
     * @return string
     */
    public function getQueueUrl($targetUrl = null, $sslEnabled = null, $domainAlias = null, $language = null, $layoutName = null);

    /**
     * Get the cancel URL
     *
     * @param string  $landingPage
     * @param [type]  $queueId
     * @param boolean $sslEnabled
     * @param string  $domainAlias
     *
     * @return string
     */
    public function getCancelUrl($landingPage = null, $queueId = null, $sslEnabled = null, $domainAlias = null);

    /**
     * Get landing page URL
     *
     * @param string $targetUrl
     *
     * @return string
     */
    public function getLandingPageUrl($targetUrl = null);
}
