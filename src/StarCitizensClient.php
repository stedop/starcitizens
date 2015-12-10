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

    public function __construct()
    {
        $this->client = new Client(
            [
                'http_error' => false,
                'base_uri'   => StarCitizensClient::APIURL
            ]
        );
    }

    public function createRequest($options = [])
    {
        return $this->client->request("GET", "",$options);
    }

    public function getResult(Request $request)
    {
        return $this->client->send($request);
    }

}