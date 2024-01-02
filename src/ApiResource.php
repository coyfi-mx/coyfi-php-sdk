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
        if (Coyfi::isProduction()) {
            $base_uri = 'http://coyfi-backend.house/api/';
        } else {
            $base_uri = 'http://coyfi-backend.house/api/';
        }

        if (! Coyfi::getKey() || ! Coyfi::getSecret()) {
            throw new NoKeyProvidedException;
        }
        $this->client = new Client([
            'base_uri' => $base_uri,
            'auth' => [Coyfi::getKey(), Coyfi::getSecret()],
            'timeout' => 30.0,
        ]
        );
    }

    /**
     * @throws APIException
     */
    public static function post($uri, $json): array
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
        return json_decode($response->getBody()->getContents(), true);
    }
}
