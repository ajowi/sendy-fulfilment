<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment\Tests\TestCase;
use Ajowi\SendyFulfilment\TrackOrderRequest;

class TrackOrderRequestTest extends TestCase
{
    public function testGetData(): void
    {
        $restRequest = new SendyRestRequestTest();
        $orderNumber = "AS137J382-9X7";
        $fetchRequest = new TrackOrderRequest($this->getEndpoint(), $this->getApiKey());
        $fetchRequest->initialize($restRequest->getDefaultTrackOrderRequest($orderNumber));
        $this->assertTrue(!empty($fetchRequest->getData()));
        $this->assertEquals($fetchRequest->getData()['orderNumber'], $orderNumber);
    }

    public function testGetEndpoint(): void
    {
        $restRequest = new SendyRestRequestTest();
        $orderNumber = "AS137J382-9X7";
        $fetchRequest = new TrackOrderRequest($this->getEndpoint(), $this->getApiKey());
        $fetchRequest->initialize($restRequest->getDefaultTrackOrderRequest($orderNumber));
        $this->assertEquals($fetchRequest->getEndpoint(), $this->getEndpoint() . '/orders/' . $orderNumber);
    }
}
