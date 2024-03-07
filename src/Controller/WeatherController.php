<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Service\WeatherService;


class WeatherController extends AbstractController
{
    private WeatherService $weatherService;

    public function __construct(WeatherService $weatherService) 
    {
        $this->weatherService = $weatherService;
    }

    #[Route('/weather', name: 'app_weather')]
    public function showWeather(): Response
    {
        $meteo = $this->weatherService->getWeather();
        dd($meteo);
        return $this->render('weather/index.html.twig', [
            'controller_name' => 'WeatherController',
        ]);
    }
}
