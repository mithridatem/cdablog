<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class WeatherService
{
    private HttpClientInterface $client;
    private string $apiKey;

    public function __construct($apiKey, HttpClientInterface $client) 
    {
        $this->apiKey = $apiKey;

        $this->client = $client;
    }

    public function getWeather() :array
    {
        //requête sur l'api
        $data = $this->client->request(
            "GET",
            "https://api.openweathermap.org/data/2.5/weather?lon=1.44&lat=43.6&appid=" . $this->apiKey
        );
        //transforme la réponse en tableau
        $response = $data->toArray();
        //Retourne le tableau
        return $response;
    }

    public function getWeatherByCity(string $city) :array 
    {
        try {
            //requête API
            $data = $this->client->request(
                "GET",
                "https://api.openweathermap.org/data/2.5/weather?q=" . $city .   "&appid=" . $this->apiKey,
            );
            //test si la ville n'existe pas
            if($data->getStatusCode() === 404) {
                //retourner un exeception
                throw new \Exception("La ville n'existe pas"); 
            }
            //stocket le tableau avec la météo ville
            $response = $data->toArray();
            //retourner le tableau
            return $response;
        } 
        catch (\Throwable $th) {
            return ["erreur"=> $th->getMessage(), "cod" => 404];
        }
    }
    //version sans try catch (à ne pas utiliser)
    public function getWeatherByCityV2(string $city) :array 
    {
        //requête API
        $data = $this->client->request(
            "GET",
            "https://api.openweathermap.org/data/2.5/weather?q=" . $city .   "&appid=" . $this->apiKey,
        );
        //stocket le tableau avec la météo ville
        $response = $data->toArray();
        //retourner le tableau
        return $response;
    }
}
