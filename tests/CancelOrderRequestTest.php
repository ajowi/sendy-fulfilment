<?php
namespace Ajowi\SendyFulfilment\Tests;

use Ajowi\SendyFulfilment\CancelOrderRequest;
use Ajowi\SendyFulfilment\Tests\TestCase;

class CancelOrderRequestTest extends TestCase
{
    public function testGetData(): void
    {
        $restRequest = new SendyRestRequestTest();
        $cancelId = 0;
        $orderNumber = "AS137J382-9X7";
        $cancelRequest = new CancelOrderRequest($this->getEndpoint(), $this->getApiKey());
        $cancelRequest->initialize($restRequest->getDefaultCancelRequest($cancelId, $orderNumber));
        $this->assertTrue(!empty($cancelRequest->getData()));
        $this->assertEquals($cancelRequest->getData()['cancel_reason_id'], $cancelId);
        $this->assertEquals($cancelRequest->getData()['orderNumber'], $orderNumber);
    }

    public function testGetEndpoint(): void
    {
        $restRequest = new SendyRestRequestTest();
        $cancelId = 0;
        $orderNumber = "AS137J382-9X7";
        $cancelRequest = new CancelOrderRequest($this->getEndpoint(), $this->getApiKey());
        $cancelRequest->initialize($restRequest->getDefaultCancelRequest($cancelId, $orderNumber));
        $this->assertEquals($cancelRequest->getEndpoint(), $this->getEndpoint() . '/orders/' . $orderNumber . '/cancel');
    }

}
