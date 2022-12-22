<?php

namespace Ajowi\SendyFulfilment\Tests;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Ajowi\SendyFulfilment\SendyClient;
use Psr\Http\Message\ResponseFactoryInterface;
use Http\Discovery\Psr17FactoryDiscovery;
use Http\Discovery\StreamFactoryDiscovery;

class TestCase extends PHPUnitTestCase
{
    protected $client;
    protected $response;

    protected function setUp() : void
    {
        $this->client = $this->createMock(SendyClient::class);
    }

    protected function getClient()
    {
        return $this->client;

    }

    protected function getDefaultResponse()
    {
        return $this->response;
    }

    protected function mockRequest($method, $path, $params,
        $return, $rcode = 200)
    {
        $this->client->expects($this->any())
             ->method('request')
             ->with($method, $path,
                $this->anything(), $params)
             ->willReturn(
                $this->createResponse($rcode)
                    ->withBody($this->createStream(json_encode($return), $rcode))
             );

    }

    protected function createResponse($rcode)
    {
        $responseFactory = Psr17FactoryDiscovery::findResponseFactory();
        $response = $responseFactory->createResponse($rcode);
        return $response;
    }

    protected function createStream($data)
    {
        $streamFactory = StreamFactoryDiscovery::find();;
        $stream = $streamFactory->createStream($data);
        return $stream;
    }

}
