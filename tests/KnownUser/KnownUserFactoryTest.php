<?php

namespace Opifer\QueueIt\KnownUser;

use Opifer\QueueIt\Redirect\RedirectType;
use Opifer\QueueIt\Exception\KnownUserException;
use Opifer\QueueIt\Exception\InvalidKnownUserUrlException;
use Opifer\QueueIt\Exception\InvalidKnownUserHashException;

class KnownUserFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        KnownUserFactory::reset(false);
    }

    public function testVerifyMd5Hash()
    {
        //Arrange
        $prefix = null;
        $sharedKey = "zaqxswcdevfrbgtnhymjukiloZAQCDEFRBGTNHYMJUKILOPlkjhgfdsapoiuytrewqmnbvcx";

        $expectedPlaceInqueue = 7810;
        $expectedQueueId = "fe070f51-5548-403c-9f0a-2626c15cb81b";
        $placeInQueueEncrypted = "3d20e598-0304-474f-87e8-371a34073d3b";
        $unixTimestamp = 1360241766;
        $expectedTimeStamp = new \DateTime("2013-02-07 12:56:06", new \DateTimeZone("UTC"));
        $expectedCustomerId = "somecust";
        $expectedEventId = "someevent";
        $expectedOriginalUrl = "http://www.example.com/test.aspx?prop=value";
        $expectedRedirectType = RedirectType::Queue;

        $urlNoHash = $expectedOriginalUrl . "?".$prefix."c=somecust&".$prefix."e=someevent&".$prefix."q=".$expectedQueueId."&".$prefix."p=".$placeInQueueEncrypted."&".$prefix."ts=".$unixTimestamp."&".$prefix."rt=queue&".$prefix."h=";

        $expectedHash = md5(utf8_encode($urlNoHash . $sharedKey));

        $url = $urlNoHash.$expectedHash;

        $urlProvider = new MockUrlProvider(
            $url,
            $expectedOriginalUrl, 
            $expectedQueueId, 
            $placeInQueueEncrypted, 
            (string)$unixTimestamp, 
            $expectedCustomerId,
            $expectedEventId,
            "queue");

        //Act
        $knownUser = KnownUserFactory::verifyMd5Hash(
            $sharedKey,
            $urlProvider,
            $prefix);

        $this->assertNotNull($knownUser);
        $this->assertEquals($expectedQueueId, $knownUser->getQueueId());
        $this->assertEquals($expectedPlaceInqueue, $knownUser->getPlaceInQueue());
        $this->assertEquals($expectedTimeStamp, $knownUser->getTimeStamp());
        $this->assertEquals($expectedCustomerId, $knownUser->getCustomerId());
        $this->assertEquals($expectedEventId, $knownUser->getEventId());
        $this->assertEquals($expectedRedirectType, $knownUser->getRedirectType());
        $this->assertEquals($expectedOriginalUrl, $knownUser->getOriginalUrl());
    }

    public function testVerifyMd5Hash_inifile()
    {
        $prefix = null;
        $sharedKey = "zaqxswcdevfrbgtnhymjukiloZAQCDEFRBGTNHYMJUKILOPlkjhgfdsapoiuytrewqmnbvcx";

        $expectedPlaceInqueue = 7810;
        $expectedQueueId = "fe070f51-5548-403c-9f0a-2626c15cb81b";
        $placeInQueueEncrypted = "3d20e598-0304-474f-87e8-371a34073d3b";
        $unixTimestamp = 1360241766;
        $expectedTimeStamp = new \DateTime("2013-02-07 12:56:06", new \DateTimeZone("UTC"));
        $expectedCustomerId = "somecust";
        $expectedEventId = "someevent";
        $expectedOriginalUrl = "http://www.example.com/test.aspx?prop=value";

        $urlNoHash = $expectedOriginalUrl . "?".$prefix."c=somecust&".$prefix."e=someevent&".$prefix."q=".$expectedQueueId."&".$prefix."p=".$placeInQueueEncrypted."&".$prefix."ts=".$unixTimestamp."&".$prefix."h=";

        $expectedHash = md5(utf8_encode($urlNoHash . $sharedKey));

        $url = $urlNoHash.$expectedHash;

        $urlProvider = new MockUrlProvider(
            $url,
            $expectedOriginalUrl,
            $expectedQueueId,
            $placeInQueueEncrypted,
            (string)$unixTimestamp,
            $expectedCustomerId,
            $expectedEventId);

        KnownUserFactory::reset(true);
        $knownUser = KnownUserFactory::verifyMd5Hash($sharedKey, $urlProvider, null);

        $this->assertNotNull($knownUser);
        $this->assertEquals($expectedQueueId, $knownUser->getQueueId());
        $this->assertEquals($expectedPlaceInqueue, $knownUser->getPlaceInQueue());
        $this->assertEquals($expectedTimeStamp, $knownUser->getTimeStamp());
        $this->assertEquals($expectedCustomerId, $knownUser->getCustomerId());
        $this->assertEquals($expectedEventId, $knownUser->getEventId());
        $this->assertEquals($expectedOriginalUrl, $knownUser->getOriginalUrl());
    }

    public function testVerifyMd5Hash_withprefix()
    {
        //Arrange
        $prefix = 'pre';
        $sharedKey = "zaqxswcdevfrbgtnhymjukiloZAQCDEFRBGTNHYMJUKILOPlkjhgfdsapoiuytrewqmnbvcx";

        $expectedPlaceInqueue = 7810;
        $expectedQueueId = "fe070f51-5548-403c-9f0a-2626c15cb81b";
        $placeInQueueEncrypted = "3d20e598-0304-474f-87e8-371a34073d3b";
        $unixTimestamp = 1360241766;
        $expectedTimeStamp = new \DateTime("2013-02-07 12:56:06", new \DateTimeZone("UTC"));
        $expectedCustomerId = "somecust";
        $expectedEventId = "someevent";

        $urlNoHash = "http://q.queue-it.net/inqueue.aspx?".$prefix."c=somecust&".$prefix."e=someevent&".$prefix."q=".$expectedQueueId."&".$prefix."p=".$placeInQueueEncrypted."&".$prefix."ts=".$unixTimestamp."&".$prefix."h=";

        $expectedHash = md5(utf8_encode($urlNoHash . $sharedKey));

        $url = $urlNoHash.$expectedHash;

        $urlProvider = new MockUrlProvider(
            $url,
            "http://q.queue-it.net/inqueue.aspx", 
            $expectedQueueId, 
            $placeInQueueEncrypted, 
            (string)$unixTimestamp, 
            $expectedCustomerId,
            $expectedEventId);

        $knownUser = KnownUserFactory::verifyMd5Hash($sharedKey, $urlProvider, $prefix);

        $this->assertNotNull($knownUser);
    }

    public function testVerifyMd5Hash_notokens()
    {
        $prefix = null;
        $sharedKey = "zaqxswcdevfrbgtnhymjukiloZAQCDEFRBGTNHYMJUKILOPlkjhgfdsapoiuytrewqmnbvcx";

        $url = "http://q.queue-it.net/inqueue.aspx?prop=value";

        $urlProvider = new MockUrlProvider($url, $url);

        $knownUser = KnownUserFactory::verifyMd5Hash($sharedKey, $urlProvider, $prefix);

        $this->assertNull($knownUser);
    }

    /**
     * @expectedException Opifer\QueueIt\Exception\InvalidKnownUserUrlException
     */
    public function testVerifyMd5Hash_missingparameters()
    {
        $prefix = null;
        $sharedKey = "zaqxswcdevfrbgtnhymjukiloZAQCDEFRBGTNHYMJUKILOPlkjhgfdsapoiuytrewqmnbvcx";

        $urlNoHash = "http://www.example.com/test.aspx?prop=value&q=fe070f51-5548-403c-9f0a-2626c15cb81b&h=asdfasdfasdfasdfasdfasdfasfasdf";

        $urlProvider = new MockUrlProvider($urlNoHash, $urlNoHash, "fe070f51-5548-403c-9f0a-2626c15cb81b");

        $knownUser = KnownUserFactory::verifyMd5Hash($sharedKey, $urlProvider, $prefix);
    }

    /**
     * @expectedException Opifer\QueueIt\Exception\InvalidKnownUserHashException
     * @expectedExceptionMessage The hash of the request is invalid
     */
    public function testVerifyMd5Hash_InvalidHash()
    {
        //Arrange
        $prefix = null;
        $sharedKey = "zaqxswcdevfrbgtnhymjukiloZAQCDEFRBGTNHYMJUKILOPlkjhgfdsapoiuytrewqmnbvcx";

        $expectedPlaceInqueue = 7810;
        $expectedQueueId = "fe070f51-5548-403c-9f0a-2626c15cb81b";
        $placeInQueueEncrypted = "3d20e598-0304-474f-87e8-371a34073d3b";
        $unixTimestamp = 1360241766;
        $expectedTimeStamp = new \DateTime("2013-02-07 12:56:06", new \DateTimeZone("UTC"));
        $expectedCustomerId = "somecust";
        $expectedEventId = "someevent";
        $expectedOriginalUrl = "http://www.example.com/test.aspx?prop=value";

        $urlNoHash = $expectedOriginalUrl . "?".$prefix."c=somecust&".$prefix."e=someevent&".$prefix."q=".$expectedQueueId."&".$prefix."p=".$placeInQueueEncrypted."&".$prefix."ts=".$unixTimestamp."&".$prefix."h=";

        $expectedHash = "INVALIDHASHxxxxxxxxxxxxxxxxxxxx";

        $url = $urlNoHash.$expectedHash;

        $urlProvider = new MockUrlProvider(
            $url,
            $expectedOriginalUrl,
            $expectedQueueId,
            $placeInQueueEncrypted,
            (string)$unixTimestamp,
            $expectedCustomerId,
            $expectedEventId);

        $knownUser = KnownUserFactory::verifyMd5Hash(
            $sharedKey,
            $urlProvider,
            $prefix);
    }

    public function testVerifyMd5Hash_KnownUserException()
    {
        $prefix = null;
        $sharedKey = "zaqxswcdevfrbgtnhymjukiloZAQCDEFRBGTNHYMJUKILOPlkjhgfdsapoiuytrewqmnbvcx";

        $expectedPlaceInqueue = 7810;
        $expectedQueueId = "fe070f51-5548-403c-9f0a-2626c15cb81b";
        $placeInQueueEncrypted = "3d20e598-0304-474f-87e8-371a34073d3b";
        $unixTimestamp = 1360241766;
        $expectedTimeStamp = new \DateTime("2013-02-07 12:56:06", new \DateTimeZone("UTC"));
        $expectedCustomerId = "somecust";
        $expectedEventId = "someevent";
        $expectedOriginalUrl = "http://www.example.com/test.aspx?prop=value";

        $urlNoHash = $expectedOriginalUrl . "?".$prefix."c=somecust&".$prefix."e=someevent&".$prefix."q=".$expectedQueueId."&".$prefix."p=".$placeInQueueEncrypted."&".$prefix."ts=".$unixTimestamp."&".$prefix."h=";

        $expectedHash = "INVALIDHASHxxxxxxxxxxxxxxxxxxxx";

        $url = $urlNoHash.$expectedHash;

        $urlProvider = new MockUrlProvider(
            $url,
            $expectedOriginalUrl,
            $expectedQueueId,
            $placeInQueueEncrypted,
            (string)$unixTimestamp,
            $expectedCustomerId,
            $expectedEventId);

        try {
            $knownUser = KnownUserFactory::verifyMd5Hash($sharedKey, $urlProvider, $prefix);
        } catch (KnownUserException $e) {
            $this->assertEquals($url, $e->getValidationUrl());
            $this->assertEquals($expectedOriginalUrl, $e->getOriginalUrl());
        }       
    }
}

class MockUrlProvider implements KnownUserUrlProviderInterface
{
    private $url;
    private $queueId;
    private $placeInQueue;
    private $timestamp;
    private $eventId;
    private $customerId;
    private $redirectType;
    private $originalUrl;

    public function __construct(
            $url, 
            $originalUrl = null, 
            $queueId = null, 
            $placeInQueue = null, 
            $timestamp = null, 
            $customerId = null, 
            $eventId = null,
            $redirectType = null)
    {
        $this->url = $url;
        $this->queueId = $queueId;
        $this->placeInQueue = $placeInQueue;
        $this->timestamp = $timestamp;
        $this->eventId = $eventId;
        $this->customerId = $customerId;
        $this->redirectType = $redirectType;
        $this->originalUrl = $originalUrl;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getQueueId($queueStringPrefix)
    {
        return $this->queueId;      
    }
    public function getPlaceInQueue($queueStringPrefix)
    {
        return $this->placeInQueue;
    }
    public function getTimeStamp($queueStringPrefix)
    {
        return $this->timestamp;
    }
    public function getEventId($queueStringPrefix)
    {
        return $this->eventId;
    }
    public function getCustomerId($queueStringPrefix)
    {
        return $this->customerId;
    }
    public function getRedirectType($queueStringPrefix)
    {
        return $this->redirectType;
    }   
    public function getOriginalUrl($queueStringPrefix)
    {
        return $this->originalUrl;
    }
}
