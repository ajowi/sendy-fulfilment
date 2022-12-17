<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment;
use Ajowi\SendyFulfilment\SendyRestRequest;
use Ajowi\SendyFulfilment\Exceptions\RequestException;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{
    public function testInvalidApiTokenProvided(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->hasApiKey(), false);
    }

    public function testInTestApiMode(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->getTestMode(), true);
    }

    public function testEndpointNotSet(): void
    {
        $restRequest = new SendyRestRequest();
        $this->assertEquals($restRequest->hasEndpoint(), false);
    }
}
