<?php
/**
 * @author Printcart <printcart@gmail.com>
 * Created at 01/18/21 10:00 AM GTM+07:00
 */

declare(strict_types=1);

namespace Printcart\Design\Service;

use GuzzleHttp\Client;
use GuzzleHttp\ClientFactory;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\ResponseFactory;
use Magento\Framework\Webapi\Rest\Request;

/**
 * Class PrintcartApiService
 */
class PrintcartApiService
{
    /**
     * API request URL
     */
    const API_REQUEST_URI = 'https://api.printcart.com/v1/';

    /**
     * API request endpoint
     */
    const API_REQUEST_ENDPOINT = 'integration/magento/products/';
    const API_POST_ENDPOINT = 'projects';

    /**
     * @var ResponseFactory
     */
    private $responseFactory;

    /**
     * @var ClientFactory
     */
    private $clientFactory;

    /**
     * GitApiService constructor
     *
     * @param ClientFactory $clientFactory
     * @param ResponseFactory $responseFactory
     */
    public function __construct(
        ClientFactory $clientFactory,
        ResponseFactory $responseFactory
    ) {
        $this->clientFactory = $clientFactory;
        $this->responseFactory = $responseFactory;
    }

    /**
     * Fetch product data from API
     */
    public function getResponse($productId, $token)
    {
        $response = $this->doRequest(static::API_REQUEST_ENDPOINT . $productId, $token);
        $status = $response->getStatusCode(); // 200 status code
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents(); // here you will have the API response in JSON format
        if ($status == 200) {
            return $responseContent;
        }
    }

    /**
     * Post project with API
     */
    public function createProject($data, $token)
    {
        $response = $this->postRequest(static::API_POST_ENDPOINT, $token, $data);
        $responseBody = $response->getBody();
        $responseContent = $responseBody->getContents(); // here you will have the API response in JSON format
        return $responseContent;
    }

    /**
     * Do API request
     *
     * @param string $uriEndpoint
     * @param string $token
     * @param string $requestMethod
     *
     * @return Response
     */
    private function doRequest(
        string $uriEndpoint,
        string $token,
        string $requestMethod = Request::HTTP_METHOD_GET
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);

        $headers = [
            'X-PrintCart-Unauth-Token' => $token,
            'Content-Type'  => 'application/json'
        ];

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                [
                    'headers' => $headers
                ]
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }

    /**
     * Do API request
     *
     * @param string $uriEndpoint
     * @param string $token
     * @param array $data
     * @param string $requestMethod
     *
     * @return Response
     */
    private function postRequest(
        string $uriEndpoint,
        string $token,
        array $data,
        string $requestMethod = Request::HTTP_METHOD_POST
    ): Response {
        /** @var Client $client */
        $client = $this->clientFactory->create(['config' => [
            'base_uri' => self::API_REQUEST_URI
        ]]);

        $headers = [
            'X-PrintCart-Unauth-Token' => $token,
            'Content-Type'  => 'application/json'
        ];

        try {
            $response = $client->request(
                $requestMethod,
                $uriEndpoint,
                [
                    'headers' => $headers,
                    \GuzzleHttp\RequestOptions::JSON => $data,
                ]
            );
        } catch (GuzzleException $exception) {
            /** @var Response $response */
            $response = $this->responseFactory->create([
                'status' => $exception->getCode(),
                'reason' => $exception->getMessage()
            ]);
        }

        return $response;
    }
}
