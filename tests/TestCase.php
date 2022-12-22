<?php

namespace Ajowi\SendyFulfilment\Tests;
use PHPUnit\Framework\TestCase as PHPUnitTestCase;
use Ajowi\SendyFulfilment\SendyClient;

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

    protected function mockRequest($method, $path, $params = array(),
        $return = array(), $rcode = 200)
    {
        $this->client->expects($this->any())
             ->method('request')
             ->with(strtolower($method), $path,
                $this->anything(), $params)
             ->willReturn(array(json_encode($return), $rcode));

    }

}
