<?php
namespace Ajowi\SendyFulfilment\Tests;
use Ajowi\SendyFulfilment\Tests\TestCase;
use Ajowi\SendyFulfilment\RestResponse;
use Ajowi\SendyFulfilment\SendyRestRequest;

class RestResponseTest extends TestCase
{
    public function testGetStatusTrue(): void
    {
        $restRequest = new SendyRestRequest();
        $data = array('status' => true, 'message' => 'Successfull');
        $response = new RestResponse($restRequest, $data);
        $this->assertEquals($response->getStatus(), $data['status']);
    }

    public function testGetStatusFalse(): void
    {
        $restRequest = new SendyRestRequest();
        $data = array('status' => false, 'message' => 'Successfull');
        $response = new RestResponse($restRequest, $data);
        $this->assertEquals($response->getStatus(), $data['status']);
    }

    public function testGetData(): void
    {
        $restRequest = new SendyRestRequest();
        $restRequestTest = new SendyRestRequestTest();
        $response = new RestResponse($restRequest, $restRequestTest->getDefaultResponseWithData());
        $this->assertTrue(!empty($response->getData()));
    }

    public function testGetCodeSuccess(): void
    {
        $restRequest = new SendyRestRequest();
        $responseCode = 200;
        $data = array('status' => true, 'message' => 'Successfull');
        $response = new RestResponse($restRequest, $data);
        $this->assertSame($response->getCode(), $responseCode);
    }

    public function testGetCodeValidationError(): void
    {
        $restRequest = new SendyRestRequest();
        $responseCode = 422;
        $data = array('status' => true, 'message' => 'Validation failed');
        $response = new RestResponse($restRequest, $data, $responseCode);
        $this->assertSame($response->getCode(), $responseCode);
    }

    public function testGetCodeUnexpectedServerError(): void
    {
        $restRequest = new SendyRestRequest();
        $responseCode = 500;
        $data = array('status' => true, 'message' => 'Unexpected server error');
        $response = new RestResponse($restRequest, $data, $responseCode);
        $this->assertSame($response->getCode(), $responseCode);
    }

    public function testGetMessage(): void
    {
        $restRequest = new SendyRestRequest();
        $data = array('status' => false, 'message' => 'Successfull');
        $response = new RestResponse($restRequest, $data);
        $this->assertEquals($response->getMessage(), $data['message']);
    }

    public function testGetResponse(): void
    {
        $restRequest = new SendyRestRequest();
        $restRequestTest = new SendyRestRequestTest();
        $response = new RestResponse($restRequest, $restRequestTest->getDefaultResponseWithData());
        $this->assertTrue(!empty($response->getResponse()));
    }
}
