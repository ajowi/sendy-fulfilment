<?php
namespace Ajowi\SendyFulfilment;

use Ajowi\SendyFulfilment\Exceptions\RequestException;
use Ajowi\SendyFulfilment\SendyClient;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class SendyRestRequest
{
    const API_VERSION = '';//'v2';//config('services.sendy.api_version');

    /**
     * Sandbox Endpoint URL
     *
     * @var string URL
     */
    const TEST_ENDPOINT = '';//'https://api.sendyit.com'; //config('services.sendy.test_endpoint');

    /**
     * Live Endpoint URL
     *
     * @var string URL
     */
    const LIVE_ENDPOINT = '';//'https://api.sendyit.com'; //config('services.sendy.live_endpoint');

    /**
     * @var string $apiKey The API key that's to be used to make requests.
     */
    const API_KEY = ''; //config('services.sendy.token');

    /**
     * @var string $apiKey The API key that's to be used to make requests.
     */
    const TEST_MODE = false; //config('services.sendy.token');

     /**
     * The request client.
     *
     * @var SendyClient
     */
    protected $httpClient;

    /**
     * The HTTP request object.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $httpRequest;

    /**
     * An associated RestResponse.
     *
     * @var RestResponse
     */
    protected $response;

    /**
     * The request parameters
     *
     * @var array
     */
    protected $data;

    /**
     * Create a new Request
     *
     */
    public function __construct()
    {
        $this->httpClient = new SendyClient();
        $this->httpRequest = HttpRequest::createFromGlobals();
    }

    /**
     * Initialize request body
     *
     */
    public function initialize($data){
        $this->data = $data;
        return $this;
    }

    /**
     * Get HTTP Method.
     *
     * This is nearly always POST but can be over-ridden in sub classes.
     *
     * @return string
     */
    protected function getHttpMethod()
    {
        return 'POST';
    }

    /**
     * Get API Endpoint
     */
    protected function getEndpoint()
    {
        $base = $this->getTestMode() ? self::TEST_ENDPOINT : self::LIVE_ENDPOINT;
        return $base . '/' . self::API_VERSION;
    }

    /**
     * Checks if API Endpoint config is set
     */
    public function hasEndpoint()
    {
        return !empty($this->getEndpoint()) ?? false;
    }

     /**
     * Gets the test mode of the request from the gateway.
     *
     * @return boolean
     */
    public function getTestMode()
    {
        //return config('services.sendy.test_mode') ?: false;
        return self::TEST_MODE;
    }

    public function sendData($data)
    {
        $body = $this->toJSON($data);
        //Log::info($body);
        try {
            $httpResponse = $this->httpClient->request(
                $this->getHttpMethod(),
                $this->getEndpoint(),
                array(
                    'Accept' => 'application/json',
                    'Authorization' => 'Bearer ' . $this->getApiKey(),
                    'Content-type' => 'application/json',
                ),
                $body
            );
            // Empty response body should be parsed also as and empty array
            $body = (string)$httpResponse->getBody()->getContents();
            $jsonToArrayResponse = !empty($body) ? json_decode($body, true) : array();
            return $this->response = $this->createResponse($jsonToArrayResponse, $httpResponse->getStatusCode());
        } catch (\Exception $e) {
            throw new RequestException($e->getMessage(),$e->getCode());
        }
    }

    /**
     * Returns object JSON representation required by Sendy.
     * @param int $options http://php.net/manual/en/json.constants.php
     * @return string
     */
    public function toJSON($data, $options = 0)
    {
        // Because of PHP Version 5.3, we cannot use JSON_UNESCAPED_SLASHES option
        // Instead we would use the str_replace command for now.
        // TODO: Replace this code with return json_encode($this->toArray(), $options | 64); once we support PHP >= 5.4
        if (version_compare(phpversion(), '5.4.0', '>=') === true) {
            return json_encode($data, $options | 64);
        }

        return str_replace('\\/', '/', json_encode($data, $options));
    }

    protected function createResponse($data, $statusCode)
    {
        return $this->response = new RestResponse($this, $data, $statusCode);
    }

    /**
     * Get API authentication token
     */
    private function getApiKey()
    {
        $apiKey = self::API_KEY;
        // if (!$apiKey) {
        //     throw new RequestException('No credentials/authentication token provided.');
        // }
        return $apiKey;
    }

    /**
     * Checks if API authentication token config is set
     */
    public function hasApiKey()
    {
        return !empty($this->getApiKey()) ?? false;
    }

    /**
     * Get request payload
     */
    public function getData()
    {
        return $this->data;
    }

     /**
     * Send the request
     *
     * @return RestResponse
     */
    public function send()
    {
        $data = $this->getData();

        return $this->sendData($data);
    }

    /**
     * Get the associated Response.
     *
     * @return RestResponse
     */
    public function getResponse()
    {
        if (null === $this->response) {
            throw new RuntimeException('Must call send on the SendyClient!');
        }

        return $this->response;
    }

}
