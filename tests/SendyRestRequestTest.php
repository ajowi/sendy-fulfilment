<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment\SendyRestRequest;
use PHPUnit\Framework\TestCase;

class SendyRestRequestTest extends TestCase
{
    public function testValidApiTokenProvided(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->hasApiKey(), false);
    }

    public function testApiEndpointIsSet(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->hasEndpoint(), false);
    }
}
