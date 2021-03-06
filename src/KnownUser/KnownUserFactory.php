<?php

namespace Opifer\QueueIt\KnownUser;

use InvalidArgumentException, DateTime, DateTimeZone;

use Opifer\QueueIt\Redirect\RedirectType;
use Opifer\QueueIt\Exception\KnownUserException;
use Opifer\QueueIt\Exception\InvalidKnownUserHashException;
use Opifer\QueueIt\Exception\InvalidKnownUserUrlException;
use Opifer\QueueIt\Identifier\Identifier;

class KnownUserFactory
{
    private static $defaultQueueStringPrefix;
    private static $defaultSecretKey;
    private static $defaultUrlProviderFactory;

    /**
     * Reset
     *
     * @param boolean $loadConfiguration
     *
     * @return void
     */
    public static function reset($loadConfiguration = false)
    {
        global $defaultQueryStringPrefix, $defaultSecretKey, $defaultUrlProviderFactory;

        $defaultQueryStringPrefix = null;
        $defaultSecretKey = null;
        $defaultUrlProviderFactory = function () { return new DefaultKnownUserUrlProvider(); };

        if (!$loadConfiguration)
            return;

        $iniFileName = $_SERVER['DOCUMENT_ROOT'] . "/../queueit.ini";

        if (!file_exists($iniFileName))
            return;

        $settings_array = parse_ini_file($iniFileName, true);

        if (!$settings_array)
            return;

        $settings = $settings_array['settings'];

        if ($settings == null)
            return;

        if (isset($settings['secretKey']) && $settings['secretKey'] != null)
            $defaultSecretKey = $settings['secretKey'];
        if (isset($settings['queryStringPrefix']) && $settings['queryStringPrefix'] != null)
            $defaultQueryStringPrefix = $settings['queryStringPrefix'];
    }

    /**
     * Configure
     *
     * @param string $sharedEventKey
     * @param string $urlProviderFactory
     * @param string $querystringPrefix
     *
     * @return void
     */
    public static function configure($sharedEventKey = null, $urlProviderFactory = null, $querystringPrefix = null)
    {
        global $defaultQueryStringPrefix, $defaultSecretKey, $defaultUrlProviderFactory;

        if ($sharedEventKey != null)
            $defaultSecretKey = $sharedEventKey;
        if ($urlProviderFactory != null)
            $defaultUrlProviderFactory = $urlProviderFactory;
        if ($querystringPrefix != null)
            $defaultQueryStringPrefix = $querystringPrefix;
    }

    /**
     * Get secret key
     *
     * @return string
     */
    public static function getSecretKey()
    {
        global $defaultSecretKey;

        return $defaultSecretKey;
    }

    /**
     * Verify MD5 Hash
     *
     * @param string                        $secretKey
     * @param KnownUserUrlProviderInterface $urlProvider
     * @param string                        $queryStringPrefix
     *
     * @throws InvalidArgumentException                              if $secretKey is null
     * @throws Opifer\QueueIt\Exception\InvalidKnownUserUrlException
     * @throws Opifer\QueueIt\Exception\KnownUserException
     *
     * @return Opifer\QueueIt\Queue\Md5KnownUser
     */
    public static function verifyMd5Hash($secretKey = null, $urlProvider = null, $queryStringPrefix = null)
    {
        global $defaultQueryStringPrefix, $defaultSecretKey, $defaultUrlProviderFactory;

        if ($urlProvider == null)
            $urlProvider = $defaultUrlProviderFactory();
        if ($secretKey == null)
            $secretKey = $defaultSecretKey;
        if ($queryStringPrefix == null)
            $queryStringPrefix = $defaultQueryStringPrefix;

        if ($secretKey == null)
            throw new \InvalidArgumentException("Secret key is null");

        try {
            if ($urlProvider->getQueueId($queryStringPrefix) == null && $urlProvider->getPlaceInQueue($queryStringPrefix) == null && $urlProvider->getTimeStamp($queryStringPrefix) == null)
                return null;

            if ($urlProvider->getQueueId($queryStringPrefix) == null || $urlProvider->getPlaceInQueue($queryStringPrefix) == null || $urlProvider->getTimeStamp($queryStringPrefix) == null)
                throw new InvalidKnownUserUrlException();

            KnownUserFactory::verifyUrl($urlProvider->getUrl(), $secretKey);

            return new Md5KnownUser(
                $urlProvider->getQueueId($queryStringPrefix),
                KnownUserFactory::decryptPlaceInQueue($urlProvider->getPlaceInQueue($queryStringPrefix)),
                KnownUserFactory::decodeTimestamp($urlProvider->getTimeStamp($queryStringPrefix)),
                $urlProvider->getCustomerId($queryStringPrefix),
                $urlProvider->getEventId($queryStringPrefix),
                KnownUserFactory::decodeRedirectType($urlProvider->getRedirectType($queryStringPrefix)),
                $urlProvider->getOriginalUrl($queryStringPrefix)
            );
        } catch (KnownUserException $e) {
            $e->setValidationUrl($urlProvider->getUrl());
            $e->setOriginalUrl($urlProvider->getOriginalUrl($queryStringPrefix));
            throw $e;
        }
    }

    /**
     * decode Timestamp
     *
     * @param integer $timestamp
     *
     * @throws Opifer\QueueIt\Exception\InvalidKnownUserUrlException if $timestamp is not an integer
     *                                                               or is null.
     *
     * @return DateTime
     */
    private static function decodeTimestamp($timestamp)
    {
        if ($timestamp != null && is_numeric($timestamp)) {
            $date = new DateTime("now", new DateTimeZone("UTC"));
            $date->setTimestamp(intval($timestamp));

            return $date;
        }

        throw new InvalidKnownUserUrlException();
    }

    /**
     * Decode redirect type
     *
     * @param Opifer\QueueIt\Redirect\RedirectType $redirectType
     *
     * @return integer
     */
    private static function decodeRedirectType($redirectType)
    {
        return RedirectType::FromString($redirectType);
    }

    /**
     * Decrypt place-in-queue
     *
     * @param string $encryptedPlaceInQueue
     *
     * @throws Opifer\QueueIt\Exception\InvalidKnownUserUrlException
     *
     * @return integer
     */
    public static function decryptPlaceInQueue($encryptedPlaceInQueue)
    {
        if ($encryptedPlaceInQueue == null || strlen($encryptedPlaceInQueue) != 36)
            throw new InvalidKnownUserUrlException();

        $e = $encryptedPlaceInQueue;
        $p = substr($e,30,1).substr($e,3,1).substr($e,11,1).substr($e,20,1).substr($e,7,1).substr($e,26,1).substr($e,9,1); //uses one char of each string at a given starting point

        return (int) $p;
    }

    /**
     * Encrypt place-in-queue
     *
     * @param integer $placeInQueue
     *
     * @return string
     */
    public static function encryptPlaceInQueue($placeInQueue)
    {
        $identifier = new Identifier();
        $encryptedPlaceInQueue = $identifier->guid();

        $paddedPlaceInQueue = str_pad($placeInQueue, 7, "0", STR_PAD_LEFT);

        $encryptedPlaceInQueue[9] = $paddedPlaceInQueue[6];
        $encryptedPlaceInQueue[26] = $paddedPlaceInQueue[5];
        $encryptedPlaceInQueue[7] = $paddedPlaceInQueue[4];
        $encryptedPlaceInQueue[20] = $paddedPlaceInQueue[3];
        $encryptedPlaceInQueue[11] = $paddedPlaceInQueue[2];
        $encryptedPlaceInQueue[3] = $paddedPlaceInQueue[1];
        $encryptedPlaceInQueue[30] = $paddedPlaceInQueue[0];

        return $encryptedPlaceInQueue;
    }

    /**
     * Verify URL
     *
     * @param string $url
     * @param [type] $sharedEventKey
     *
     * @throws Opifer\QueueIt\Exception\InvalidKnownUserHashException when hash could not be verified
     *
     * @return void
     */
    private static function verifyUrl($url, $sharedEventKey)
    {
        $expectedHash = substr($url, -32);
        $urlNoHash=substr($url, 0, -32) . $sharedEventKey; //Remove hash value and add SharedEventKey
        $actualhash = md5(utf8_encode($urlNoHash));

        if (strcmp($actualhash, $expectedHash) != 0) {
            throw new InvalidKnownUserHashException('The hash of the request is invalid');
        }
    }
}

KnownUserFactory::reset(true);
