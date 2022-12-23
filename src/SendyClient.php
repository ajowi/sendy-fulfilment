<?php

namespace Ajowi\SendyFulfilment;

use Http\Client\HttpClient;
use Http\Discovery\HttpClientDiscovery;
use Http\Discovery\MessageFactoryDiscovery;
use Http\Message\RequestFactory;
use Ajowi\SendyFulfilment\Exceptions\NetworkException;
use Ajowi\SendyFulfilment\Exceptions\RequestException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class SendyClient
{
    /**
     * The Http Client which implements `public function sendRequest(RequestInterface $request)`
     * Note: Will be changed to PSR-18 when released
     *
     * @var HttpClient
     */
    private $httpClient;

    /**
     * @var RequestFactory
     */
    private $requestFactory;

    public function __construct($httpClient = null, RequestFactory $requestFactory = null)
    {
        $this->httpClient = $httpClient ?: HttpClientDiscovery::find();
        $this->requestFactory = $requestFactory ?: MessageFactoryDiscovery::find();
    }

    /**
     * Creates a new PSR-7 request.
     *
     * @param string $method
     * @param \Psr\Http\Message\UriInterface|string $uri
     * @param array $headers
     * @param null $body
     * @param string $protocolVersion
     * @return ResponseInterface
     * @throws \Http\Client\Exception
     */
    public function request(
        string $method,
        $uri,
        array $headers,
        $body,
        string $protocolVersion = '1.1'
    ): ResponseInterface
    {
        $request = $this->requestFactory->createRequest($method, $uri, $headers, $body, $protocolVersion);

        return $this->sendRequest($request);
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws \Http\Client\Exception
     */
    private function sendRequest(RequestInterface $request)
    {
        try {
            return $this->httpClient->sendRequest($request);
        } catch (Exceptions\NetworkException $networkException) {
            throw new NetworkException($networkException->getMessage(), $networkException->getCode(), $networkException);
        } catch (\Exception $exception) {
            throw new RequestException($exception->getMessage(), $exception->getCode(), $exception);
        }
    }
}
