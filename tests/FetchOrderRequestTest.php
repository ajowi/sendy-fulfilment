<?php
namespace Ajowi\SendyFulfilment\Tests;

use Ajowi\SendyFulfilment\FetchOrderRequest;
use Ajowi\SendyFulfilment\Tests\TestCase;

class FetchOrderRequestTest extends TestCase
{
    public function testGetData(): void
    {
        $restRequest = new SendyRestRequestTest();
        $orderNumber = "AS137J382-9X7";
        $fetchRequest = new FetchOrderRequest($this->getEndpoint(), $this->getApiKey());
        $fetchRequest->initialize($restRequest->getDefaultFetchOrderRequest($orderNumber));
        $this->assertTrue(!empty($fetchRequest->getData()));
        $this->assertEquals($fetchRequest->getData()['orderNumber'], $orderNumber);
    }

    public function testGetEndpoint(): void
    {
        $restRequest = new SendyRestRequestTest();
        $orderNumber = "AS137J382-9X7";
        $fetchRequest = new FetchOrderRequest($this->getEndpoint(), $this->getApiKey());
        $fetchRequest->initialize($restRequest->getDefaultFetchOrderRequest($orderNumber));
        $this->assertEquals($fetchRequest->getEndpoint(), $this->getEndpoint() . '/orders/' . $orderNumber . '/order-paths');
    }

}
