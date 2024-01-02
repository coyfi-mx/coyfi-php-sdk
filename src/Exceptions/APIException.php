<?php

namespace Coyfi\Exceptions;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class APIException extends Exception
{
    private ResponseInterface $response;
    private ?RequestInterface $request;

    public function __construct($response, $request = null)
    {
        $this->response = $response;
        $this->request = $request;
        $message = json_decode($this->response->getBody()->getContents(), true)['message'];
        parent::__construct(is_array($message) ? $message[0] : $message);
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getRequest()
    {
        return $this->request;
    }
}
