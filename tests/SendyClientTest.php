<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment\Tests\TestCase;
use Ajowi\SendyFulfilment\RestResponse;
use Ajowi\SendyFulfilment\SendyClient;
use Http\Client\HttpClient;
use Psr\Http\Message\ResponseInterface;

class SendyClientTest extends TestCase
{
    public function testRequest(): void
    {
        $sendyClient = new SendyClient($this->createMock(HttpClient::class));
        $this->mockRequest(
            'POST',
            $this->getEndpoint(),
            $this->getDefaultRequestData(),
            $this->getDefaultResponseData()
        );
        $response = $sendyClient->request(
            'POST',
            $this->getEndpoint(),
            $this->getDefaultRequestHeaders(),
            json_encode($this->getDefaultRequestData()));

        $this->assertTrue($response instanceof ResponseInterface);
    }

}
