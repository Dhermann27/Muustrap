<?php

namespace App;

use Facebook\Exceptions\FacebookSDKException;

/**
 * Created by PhpStorm.
 * User: danhermann
 * Date: 12/29/17
 * Time: 1:40 PM
 */
class Guzzle6HttpClient implements \Facebook\HttpClients\FacebookHttpClientInterface
{
    private $client;

    public function __construct(\GuzzleHttp\Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws FacebookSDKException
     * */
    public function send($url, $method, $body, array $headers, $timeOut)
    {
        $request = new \GuzzleHttp\Psr7\Request($method, $url, $headers, $body);
        try {
            $response = $this->client->send($request, ['timeout' => $timeOut, 'http_errors' => false]);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            throw new FacebookSDKException($e->getMessage(), $e->getCode());
        }
        $httpStatusCode = $response->getStatusCode();
        $responseHeaders = $response->getHeaders();

        foreach ($responseHeaders as $key => $values) {
            $responseHeaders[$key] = implode(', ', $values);
        }

        $responseBody = $response->getBody()->getContents();

        return new \Facebook\Http\GraphRawResponse(
            $responseHeaders,
            $responseBody,
            $httpStatusCode);
    }
}