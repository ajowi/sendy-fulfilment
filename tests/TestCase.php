<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment;
use Ajowi\SendyFulfilment\SendyRestRequest;
use Ajowi\SendyFulfilment\Exceptions\RequestException;

class TestCase extends PHPUnit\Framework\TestCase
{
    public function testInvalidApiTokenProvided(): void
    {
        $restRequest = new SendyRestRequest();
        $this->expectException(RequestException::class);
        $restRequest->getApiKey();
    }

    public function testNotInTestMode(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->getTestMode(), false);
    }

    public function testEndpointNotSet(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals(empty($restRequest->getEndpoint()), true);
    }
}
