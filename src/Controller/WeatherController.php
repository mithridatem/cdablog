<?php

namespace App\Controller;

use App\Form\WeatherType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
        
        return $this->render('weather/index.html.twig', [
            'meteo' => $meteo,
        ]);
    }

    #[Route('/weather/city', name:'app_weather_city')]
    public function showWeatherByCity(Request $request) : Response 
    {
        $meteo = [];
        $form = $this->createForm(WeatherType::class);
        $form->handleRequest($request);
        //test si le formulaire est submit
        if($form->isSubmitted()) {
           
            $meteo = $this->weatherService->getWeatherByCity($form->getData()["city"]);
        }

        return $this->render('weather/city.html.twig', [
            'form' => $form->createView(),
            'meteo' => $meteo,
        ]);
    }

    //version sans le try catch (à ne pas utiliser)
    #[Route('/weather/city/v2', name:'app_weather_city_v2')]
    public function showWeatherByCityV2(Request $request) : Response 
    {
        $meteo = [];
        $form = $this->createForm(WeatherType::class);
        $form->handleRequest($request);
        if($form->isSubmitted()) {
           
            $meteo = $this->weatherService->getWeatherByCityV2($form->getData()["city"]);
        }

        return $this->render('weather/city.html.twig', [
            'form' => $form->createView(),
            'meteo' => $meteo,
        ]);
    }
}
