<?php

namespace StarCitizen;

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;

/**
 * Class Client
 * */
class StarCitizensClient
{
    /**
     *
     */
    const APIURL =  "http://sc-api.com";

    /**
     * @var Client
     */
    private $client;

    /**
     * StarCitizensClient constructor.
     */
    public function __construct()
    {
        $this->client = new Client(
            [
                'http_error' => false,
                'base_uri'   => StarCitizensClient::APIURL
            ]
        );
    }

    /**
     * @param array $params
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function createRequest($params = [])
    {
        return $this->client->request("GET", "",$params);
    }

    /**
     * @param array $params
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     */
    public function getResult($params = [])
    {
        return $this->client->send(self::createRequest($params));
    }
}