<?php

namespace Opifer\QueueIt\KnownUser;

class DefaultKnownUserUrlProviderTest extends \PHPUnit_Framework_TestCase
{
    public function testGetUrlSimple()
    {
        $expectedUrl = "http://www.example.com/somepath/x?prop=value";

        $_SERVER["HTTPS"] = "off";
        $_SERVER["SERVER_PORT"] = "80";
        $_SERVER["SERVER_NAME"] = "www.example.com";
        $_SERVER["REQUEST_URI"] = "/somepath/x?prop=value";

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualUrl = $urlProvider->getUrl();

        $this->assertEquals($actualUrl, $expectedUrl);
    }

    public function testGetUrlHttps()
    {
        $expectedUrl = "https://www.example.com/somepath/x?prop=value";

        $_SERVER["HTTPS"] = "on";
        $_SERVER["SERVER_PORT"] = "443";
        $_SERVER["SERVER_NAME"] = "www.example.com";
        $_SERVER["REQUEST_URI"] = "/somepath/x?prop=value";

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualUrl = $urlProvider->getUrl();

        $this->assertEquals($actualUrl, $expectedUrl);
    }

    function testGetUrlOtherport()
    {
        $expectedUrl = "http://www.example.com:8080/somepath/x?prop=value";

        $_SERVER["HTTPS"] = "off";
        $_SERVER["SERVER_PORT"] = "8080";
        $_SERVER["SERVER_NAME"] = "www.example.com";
        $_SERVER["REQUEST_URI"] = "/somepath/x?prop=value";

        $urlProvider = new DefaultKnownUserUrlProvider();   

        $actualUrl = $urlProvider->getUrl();

        $this->assertEquals($actualUrl, $expectedUrl);
    }

    function testGetUrlHttpswithotherport()
    {
        $expectedUrl = "https://www.example.com:4433/somepath/x?prop=value";

        $_SERVER["HTTPS"] = "on";
        $_SERVER["SERVER_PORT"] = "4433";
        $_SERVER["SERVER_NAME"] = "www.example.com";
        $_SERVER["REQUEST_URI"] = "/somepath/x?prop=value";


        $urlProvider = new DefaultKnownUserUrlProvider();


        $actualUrl = $urlProvider->getUrl();

        $this->assertEquals($actualUrl, $expectedUrl);
    }

    function testGetQueueId()
    {
        $expectedQueueId = "48f6687b-7db3-4f95-be30-2fe82d8dcced";

        $_GET = array('q' => $expectedQueueId); 

        $urlProvider = new DefaultKnownUserUrlProvider();   

        $actualQueueId = $urlProvider->getQueueId(null);

        $this->assertEquals($actualQueueId, $expectedQueueId);
    }

    function testGetQueueIdWithprefix()
    {
        $expectedQueueId = "48f6687b-7db3-4f95-be30-2fe82d8dcced";

        $_GET = array('preq' => $expectedQueueId);

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualQueueId = $urlProvider->getQueueId('pre');

        $this->assertEquals($actualQueueId, $expectedQueueId);
    }

    function testGetPlaceInQueue()
    {
        $expectedPlaceInQueue = "48f6687b-7db3-4f95-be30-2fe82d8dcced";

        $_GET = array('p' => $expectedPlaceInQueue);

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualPlaceInQueue = $urlProvider->getPlaceInQueue(null);

        $this->assertEquals($actualPlaceInQueue, $expectedPlaceInQueue);
    }

    function testGetPlaceInQueueWithPrefix()
    {
        $expectedPlaceInQueue = "48f6687b-7db3-4f95-be30-2fe82d8dcced";

        $_GET = array('prep' => $expectedPlaceInQueue);

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualPlaceInQueue = $urlProvider->getPlaceInQueue('pre');

        $this->assertEquals($actualPlaceInQueue, $expectedPlaceInQueue);
    }

    function testGetTimestamp()
    {
        $expectedTimestamp = '1360241766';

        $_GET = array('ts' => '1360241766');

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualTimestamp = $urlProvider->getTimeStamp(null);

        $this->assertEquals($actualTimestamp, $expectedTimestamp);
    }

    function testGetTimestampWithprefix()
    {
        $expectedTimestamp = '1360241766';

        $_GET = array('prets' => '1360241766');

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualTimestamp = $urlProvider->getTimeStamp('pre');

        $this->assertEquals($actualTimestamp, $expectedTimestamp);
    }

    function testGetEventId()
    {
        $expectedEventId = "testevent";

        $_GET = array('e' => $expectedEventId);

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualEventId = $urlProvider->getEventId(null);

        $this->assertEquals($actualEventId, $expectedEventId);
    }

    function testGetEventIdWithPrefix()
    {
        $expectedEventId = "testevent";

        $_GET = array('pree' => $expectedEventId);

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualEventId = $urlProvider->getEventId('pre');

        $this->assertEquals($actualEventId, $expectedEventId);
    }

    function testGetCustomerId()
    {
        $expectedCustomerId = "testevent";

        $_GET = array('c' => $expectedCustomerId);

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualCustomerId = $urlProvider->getCustomerId(null);

        $this->assertEquals($actualCustomerId, $expectedCustomerId);
    }

    function testGetCustomerIdWithprefix()
    {
        $expectedCustomerId = "testevent";

        $_GET = array('prec' => $expectedCustomerId);

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualCustomerId = $urlProvider->getCustomerId('pre');

        $this->assertEquals($actualCustomerId, $expectedCustomerId);
    }

    function testGetOriginalUrl()
    {
        $expectedUrl = "http://www.example.com/somepath/x?prop=value";

        $_SERVER["HTTPS"] = "off";
        $_SERVER["SERVER_PORT"] = "80";
        $_SERVER["SERVER_NAME"] = "www.example.com";
        $_SERVER["REQUEST_URI"] = "/somepath/x?prop=value&c=somecust&e=someevent&q=48f6687b-7db3-4f95-be30-2fe82d8dcced&p=48f6687b-7db3-4f95-be30-2fe82d8dcced&ts=1360241766&h=sakdfhkuwekfbkshweufhskdfsdf";

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualUrl = $urlProvider->getOriginalUrl(null);

        $this->assertEquals($actualUrl, $expectedUrl);
    }

    function testGetOriginalUrlWithprefix()
    {
        $expectedUrl = "http://www.example.com/somepath/x?prop=value";

        $_SERVER["HTTPS"] = "off";
        $_SERVER["SERVER_PORT"] = "80";
        $_SERVER["SERVER_NAME"] = "www.example.com";
        $_SERVER["REQUEST_URI"] = "/somepath/x?prop=value&prec=somecust&pRee=someevent&pReq=48f6687b-7db3-4f95-be30-2fe82d8dcced&pRep=48f6687b-7db3-4f95-be30-2fe82d8dcced&prets=1360241766&pReh=sakdfhkuwekfbkshweufhskdfsdf";

        $urlProvider = new DefaultKnownUserUrlProvider();

        $actualUrl = $urlProvider->getOriginalUrl('pre');

        $this->assertEquals($actualUrl, $expectedUrl);
    }
}
