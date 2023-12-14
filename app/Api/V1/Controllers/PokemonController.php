<?php

namespace App\Api\V1\Controllers;

use App\PokeApi;
use App\Pokemon;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;

class PokemonController extends Controller
{
    private $pokeApi;

    public function __construct(PokeApi $pokeApi)
    {
        $this->pokeApi = $pokeApi;
    }

    public function get_15_pokemones()
    {
        $pokemones = [];

        // Realizo llamadas a URLs con pokemon aleatorios
        for ($i = 0; $i < 15; $i++) {
            $pokemonId = rand(1, 800);
            $url = $this->pokeApi->getUrlApi() . "pokemon/{$pokemonId}";

            
            $client = new Client();

            $response = $client->get($url);

            if ($response->getStatusCode() === 200) {
                $pokemonData = json_decode($response->getBody(), true);

                // Obtengo los tipos del pokemon
                $types = array_map(function ($type) {
                    return $type['type']['name'];
                }, $pokemonData['types']);

                // Convertir el array de tipos a un string
                $tipo = implode(', ', $types);

                // Creo el array que irá a la bd
                $pokemones[] = [
                    'name' => $pokemonData['name'],
                    'type' => $tipo,
                ];


                Pokemon::create([
                    'nombre' => $pokemonData['name'],
                    'tipo' => $tipo,
                    'created_at' => now(),
                ]);
            }
        }

        return response()->json($pokemones);
    }
}
