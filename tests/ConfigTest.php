<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment;
use Ajowi\SendyFulfilment\SendyRestRequest;
use Ajowi\SendyFulfilment\Exceptions\RequestException;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testValidApiTokenProvided(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->hasApiKey(), false);
    }

    public function testApiInTestMode(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->getTestMode(), false);
    }

    public function testApiEndpointIsSet(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->hasEndpoint(), false);
    }
}
