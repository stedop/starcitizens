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
    public function getResult($params = [])
    {
        $request = new Request("GET", '?'.http_build_query($params));
        return $this->client->send($request);
    }
}