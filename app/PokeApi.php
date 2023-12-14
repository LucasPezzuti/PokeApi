<?php

namespace App;

use Exception;
use GuzzleHttp\Client;

class PokeApi
{
    private $urlApi = "https://pokeapi.co/api/v2/";

    public function getUrlApi()
    {
        return $this->urlApi;
    }
}
