<?php
namespace Ajowi\SendyFulfilment\Tests;

use Ajowi\SendyFulfilment\PriceRequest;
use Ajowi\SendyFulfilment\Tests\TestCase;

class PriceRequestTest extends TestCase
{
    public function testGetData(): void
    {
        $restRequest = new SendyRestRequestTest();
        $ecommerceOrder = "ODR-0000";
        $priceRequest = new PriceRequest($this->getEndpoint(), $this->getApiKey());
        $priceRequest->initialize($restRequest->getDefaultPriceRequest($ecommerceOrder));
        $this->assertTrue(!empty($priceRequest->getData()));
        $this->assertEquals($priceRequest->getData()['ecommerce_order'], $ecommerceOrder);
    }

    public function testGetEndpoint(): void
    {
        $priceRequest = new PriceRequest($this->getEndpoint(), $this->getApiKey());
        $this->assertEquals($priceRequest->getEndpoint(), $this->getEndpoint() . '/price-request');
    }

}
