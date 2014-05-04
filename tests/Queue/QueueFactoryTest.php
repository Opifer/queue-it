<?php

namespace Opifer\QueueIt\Queue;

class QueueFactoryTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $_SERVER["SERVER_PORT"] = null;
        $_SERVER["SERVER_NAME"] = null;
        $_SERVER["REQUEST_URI"] = null;
        // Set the document root to the current directory, to make sure the tests
        // uses our test queueit.ini
        $_SERVER['DOCUMENT_ROOT'] = __DIR__ . '/web';

        QueueFactory::reset(false);

        QueueFactory::configure(null);
    }

    public function testCreateQueue()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";

        $queue = QueueFactory::CreateQueue($expectedCustomerId, $expectedEventId);

        $this->assertEquals($expectedCustomerId, $queue->getCustomerId());
        $this->assertEquals($expectedEventId, $queue->getEventId());
    }

    public function testCreateQueueFromConfiguration()
    {
        $expectedCustomerId = "defaultcustomerid";
        $expectedEventId = "defaulteventid";

        $queue = QueueFactory::CreateQueueFromConfiguration();

        $this->assertEquals($expectedCustomerId, $queue->getCustomerId());
        $this->assertEquals($expectedEventId, $queue->getEventId());
    }

    public function testCreateQueueFromConfigurationNamed()
    {
        $expectedCustomerId = "queue1customerid";
        $expectedEventId = "queue1eventid";

        $queue = QueueFactory::CreateQueueFromConfiguration('queue1');

        $this->assertEquals($expectedCustomerId, $queue->getCustomerId());
        $this->assertEquals($expectedEventId, $queue->getEventId());
    }

    public function testGetQueueUrl()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";

        $expectedQueueUrl =
            "http://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/?c=" . $expectedCustomerId . "&e=" . $expectedEventId;

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualQueueUrl = $queue->GetQueueUrl();

        $this->assertEquals($expectedQueueUrl, $actualQueueUrl);
    }

    public function testGetQueueUrlLanguage()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";
        $expectedLanguage = "en-US";

        $expectedQueueUrl =
        "http://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/?c=" . $expectedCustomerId . "&e=" . $expectedEventId . "&cid=" . $expectedLanguage;

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualQueueUrl = $queue->GetQueueUrl(null, null, null, $expectedLanguage);

        $this->assertEquals($expectedQueueUrl, $actualQueueUrl);
    }

    public function testGetQueueUrlLayoutName()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";
        $expectedLayoutName = "some layout";

        $expectedQueueUrl =
        "http://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/?c=" . $expectedCustomerId . "&e=" . $expectedEventId . "&l=" . urlencode($expectedLayoutName);

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualQueueUrl = $queue->GetQueueUrl(null, null, null, null, $expectedLayoutName);

        $this->assertEquals($expectedQueueUrl, $actualQueueUrl);
    }

    public function testGetQueueUrlDomainAlias()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";
        $expectedDomainAlias = "my.queue.url";

        $expectedQueueUrl =
                "http://" . $expectedDomainAlias . "/?c=" . $expectedCustomerId . "&e=" . $expectedEventId;

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualQueueUrl = $queue->GetQueueUrl(null, null, $expectedDomainAlias);

        $this->assertEquals($expectedQueueUrl, $actualQueueUrl);
    }

    public function testGetQueueUrlSsl()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";

        $expectedQueueUrl =
            "https://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/?c=" . $expectedCustomerId . "&e=" . $expectedEventId;

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualQueueUrl = $queue->GetQueueUrl(null, true, null);

        $this->assertEquals($expectedQueueUrl, $actualQueueUrl);
    }

    public function testGetQueueUrlIncludeTarget()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";
        $expectedTarget = "http://target.url/?someprop=somevalue&another=value";

        $_SERVER["SERVER_PORT"] = '80';
        $_SERVER["SERVER_NAME"] = 'target.url';
        $_SERVER["REQUEST_URI"] = '/?someprop=somevalue&another=value';

        $expectedQueueUrl =
            "http://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/?c=" . $expectedCustomerId . "&e=" . $expectedEventId . '&t=' . urlencode($expectedTarget);

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualQueueUrl = $queue->GetQueueUrl(true, null, null);

        $this->assertEquals($expectedQueueUrl, $actualQueueUrl);
    }

    public function testGetQueueUrlTargetUrl()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";
        $expectedTarget = "http://target.url/?someprop=somevalue&another=value";

        $expectedQueueUrl =
        "http://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/?c=" . $expectedCustomerId . "&e=" . $expectedEventId . '&t=' . urlencode($expectedTarget);

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualQueueUrl = $queue->GetQueueUrl($expectedTarget, null, null);

        $this->assertEquals($expectedQueueUrl, $actualQueueUrl);
    }

    public function testGetCancelUrl()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";

        $expectedCancelUrl =
            "http://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/cancel.aspx?c=" . $expectedCustomerId . "&e=" . $expectedEventId;

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualCancelUrl = $queue->GetCancelUrl();

        $this->assertEquals($expectedCancelUrl, $actualCancelUrl);
    }

    public function testGetCancelUrlSsl()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";

        $expectedCancelUrl =
        "https://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/cancel.aspx?c=" . $expectedCustomerId . "&e=" . $expectedEventId;

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualCancelUrl = $queue->GetCancelUrl(null, null, true);

        $this->assertEquals($expectedCancelUrl, $actualCancelUrl);
    }

    public function testGetCancelUrlDomainAlias()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";
        $expectedDomainAlias = 'vent.queue-it.net';

        $expectedCancelUrl =
        "http://" . $expectedDomainAlias . "/cancel.aspx?c=" . $expectedCustomerId . "&e=" . $expectedEventId;

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualCancelUrl = $queue->GetCancelUrl(null, null, null, $expectedDomainAlias);

        $this->assertEquals($expectedCancelUrl, $actualCancelUrl);
    }

    public function testGetCancelUrlLandingPage()
    {
        $expectedCustomerId = "customerid";
        $expectedEventId = "eventid";
        $expectedTarget = 'http://target.url/?someprop=somevalue&another=value';

        $expectedCancelUrl =
            "http://" . $expectedEventId . "-" . $expectedCustomerId . ".queue-it.net/cancel.aspx?c=" . $expectedCustomerId . "&e=" . $expectedEventId . "&r=" . urlEncode($expectedTarget);

        $queue = QueueFactory::createQueue($expectedCustomerId, $expectedEventId);

        $actualCancelUrl = $queue->GetCancelUrl($expectedTarget);

        $this->assertEquals($expectedCancelUrl, $actualCancelUrl);
    }

    public function testGetCancelUrlLandingPageFromConfiguration()
    {
        $expectedCustomerId = "queue1customerid";
        $expectedEventId = "queue1eventid";

        $expectedCancelUrl =
                "https://queue.mala.dk/cancel.aspx?c=" . $expectedCustomerId . "&e=" . $expectedEventId . "&r=http%3A%2F%2Fwww.mysplitpage.com%2F";

        $queue = QueueFactory::createQueueFromConfiguration('queue1');

        $actualCancelUrl = $queue->GetCancelUrl();

        $this->assertEquals($expectedCancelUrl, $actualCancelUrl);
    }

    public function testGetLandingPageUrl()
    {
        $queue = QueueFactory::createQueue("customerid", "eventid");

        $actualLandingPageUrl = $queue->getLandingPageUrl();

        $this->assertNull($actualLandingPageUrl);
    }

    public function testGetLandingPageUrlFromConfiguration()
    {
        $_SERVER["SERVER_PORT"] = '80';
        $_SERVER["SERVER_NAME"] = 'target.url';
        $_SERVER["REQUEST_URI"] = '/?someprop=somevalue&another=value';

        $expectedLandingPageUrl = "http://www.mysplitpage.com/?t=http%3A%2F%2Ftarget.url%2F%3Fsomeprop%3Dsomevalue%26another%3Dvalue";

        $queue = QueueFactory::createQueueFromConfiguration("queue1");

        $actualLandingPageUrl = $queue->getLandingPageUrl();

        $this->assertEquals($expectedLandingPageUrl, $actualLandingPageUrl);
    }

    public function testGetLandingPageUrlIncludeTarget()
    {
        $_SERVER["SERVER_PORT"] = '80';
        $_SERVER["SERVER_NAME"] = 'target.url';
        $_SERVER["REQUEST_URI"] = '/?someprop=somevalue&another=value';

        $expectedLandingPageUrl = "http://www.mysplitpage.com/?t=http%3A%2F%2Ftarget.url%2F%3Fsomeprop%3Dsomevalue%26another%3Dvalue";

        $queue = QueueFactory::createQueueFromConfiguration("queue1");

        $actualLandingPageUrl = $queue->getLandingPageUrl(true);

        $this->assertEquals($expectedLandingPageUrl, $actualLandingPageUrl);
    }

    public function testGetLandingPageUrlTargetUrl()
    {
        $expectedTarget = "http://target.url/?someprop=somevalue&another=value";
        $expectedLandingPageUrl = "http://www.mysplitpage.com/?t=http%3A%2F%2Ftarget.url%2F%3Fsomeprop%3Dsomevalue%26another%3Dvalue";

        $queue = QueueFactory::createQueueFromConfiguration("queue1");

        $actualLandingPageUrl = $queue->getLandingPageUrl($expectedTarget);

        $this->assertEquals($expectedLandingPageUrl, $actualLandingPageUrl);
    }
}
