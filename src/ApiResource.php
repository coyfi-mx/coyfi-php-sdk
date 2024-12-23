<?php

namespace Coyfi;

use Coyfi\Exceptions\APIException;
use Coyfi\Exceptions\NoKeyProvidedException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class ApiResource
{
    private static $instances = [];

    public $client;

    public function __construct()
    {
        if (! Coyfi::getKey() || ! Coyfi::getSecret()) {
            throw new NoKeyProvidedException;
        }

        $this->client = new Client([
            'base_uri' => Coyfi::config('sdk.api_url'),
            'auth' => [Coyfi::getKey(), Coyfi::getSecret()],
            'timeout' => 60.0,
        ]);
    }

    /**
     * @throws APIException
     */
    public static function post($uri, $json = [])
    {
        $apiResource = ApiResource::getInstance();
        try {
            $response = $apiResource->client->request(
                'POST',
                $uri,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'json' => $json,
                ]
            );

            return $apiResource->processResponse($response);
        } catch (ClientException $exception) {
            throw new APIException($exception->getResponse(), $exception->getRequest());
        }
    }

    public static function put($uri, $json = [])
    {
        $apiResource = ApiResource::getInstance();
        try {
            $response = $apiResource->client->request(
                'PUT',
                $uri,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'json' => [...$json, '_method' => 'PUT'],
                ]
            );

            return $apiResource->processResponse($response);
        } catch (ClientException $exception) {
            throw new APIException($exception->getResponse(), $exception->getRequest());
        }
    }

    /**
     * @throws APIException
     */
    public static function get($uri, $json = [])
    {
        $apiResource = ApiResource::getInstance();
        try {
            $response = $apiResource->client->request(
                'GET',
                $uri,
                [
                    'headers' => [
                        'Content-Type' => 'application/json',
                        'X-Requested-With' => 'XMLHttpRequest',
                    ],
                    'query' => $json,
                ]
            );

            return $apiResource->processResponse($response);
        } catch (ClientException $exception) {
            throw new APIException($exception->getResponse(), $exception->getRequest());
        }
    }

    private static function getInstance(): ApiResource
    {
        $cls = static::class;
        if (! isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static;
        }

        return self::$instances[$cls];
    }

    private function processResponse($response)
    {
        switch ($response->getHeader('Content-Type')[0]) {
            case 'application/json':
                return json_decode($response->getBody()->getContents(), true);
            case 'application/pdf':
            case 'text/xml; charset=UTF-8':
                return $response->getBody()->getContents();
        }
    }
}
