<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment\ConfirmOrderRequest;
use Ajowi\SendyFulfilment\Tests\TestCase;


class ConfirmOrderRequestTest extends TestCase
{
    public function testGetData(): void
    {
        $restRequest = new SendyRestRequestTest();
        $pricingUUID = "OdRsadd-0000";
        $orderRequest = new ConfirmOrderRequest($this->getEndpoint(), $this->getApiKey());
        $orderRequest->initialize($restRequest->getDefaultOrderRequest($pricingUUID));
        $this->assertTrue(!empty($orderRequest->getData()));
        $this->assertEquals($orderRequest->getData()['pricing_uuid'], $pricingUUID);
    }

    public function testGetEndpoint(): void
    {
        $orderRequest = new ConfirmOrderRequest($this->getEndpoint(), $this->getApiKey());
        $this->assertEquals($orderRequest->getEndpoint(), $this->getEndpoint() . '/orders');
    }

}
