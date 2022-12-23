<?php
namespace Ajowi\SendyFulfilment;

use Ajowi\SendyFulfilment\Exceptions\RequestException;
use Ajowi\SendyFulfilment\SendyClient;
use RuntimeException;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

class SendyRestRequest
{
    /**
     * API Endpoint URL
     *
     * @var string URL
     */
    protected $endPointUrl;

    /**
     * @var string $apiKey The API key that's to be used to make requests.
     */
    protected $apiKey;

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
     * @param string $endPointUrl
     * @param string $apiKey
     *
     */
    public function __construct($endPointUrl = '', $apiKey = '')
    {
        $this->httpClient = new SendyClient();
        $this->httpRequest = HttpRequest::createFromGlobals();
        if(function_exists('config')){
            $this->endPointUrl = config('services.sendy.endpoint_url');
            $this->apiKey = config('services.sendy.token');
        }
        else{
            $this->endPointUrl = $endPointUrl;
            $this->apiKey = $apiKey;
        }

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
     * Set HttpClient
     */
    public function setHttpClient($client){
        $this->httpClient = $client;
    }

    /**
     * Get HttpClient
     */
    public function getHttpClient(){
        return $this->httpClient;
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
    public function getEndpoint()
    {
        return $this->endPointUrl;
    }

    /**
     * Checks if API Endpoint URL config is set
     */
    public function hasEndpoint()
    {
        return !empty($this->getEndpoint()) ?? false;
    }

    private function sendData($data)
    {
        $body = $data; //$this->toJSON($data);
        //Log::info($body);
        if($this->hasEndpoint() && $this->hasApiKey()){
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
        else{
            throw new RequestException('No authentication token (API Key) or Endpoint URL provided.');
        }
    }

    /**
     * Returns object JSON representation.
     * @param int $options http://php.net/manual/en/json.constants.php
     * @return string
     */
    public function toJSON($data, $options = 0)
    {
        return json_encode($data, $options | 64);

    }

    private function createResponse($data, $statusCode)
    {
        return $this->response = new RestResponse($this, $data, $statusCode);
    }

    /**
     * Get API authentication token
     */
    private function getApiKey()
    {
        return $this->apiKey;
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
