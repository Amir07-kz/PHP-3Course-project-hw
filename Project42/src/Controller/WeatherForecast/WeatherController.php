<?php

namespace App\Controller\WeatherForecast;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Contracts\HttpClient\HttpClientInterface;


class WeatherController extends AbstractController
{
    #[Route("/weather/", methods: ["get"])]
    public function weatherPage(){
        return $this->render('weather/homePage.html.twig', ['value' => true]);
    }

    //https://symfony.com/doc/current/http_client.html

    private $client;

    /**
     * @param $client
     */

//    public function __construct(HttpClientInterface $client)
//    {
//        $this->client = $client;
//    }

   #[Route('/weather/app')]
   #[Route('/weather/appP')]
    public function index(Request $request): Response
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => "https://visual-crossing-weather.p.rapidapi.com/history?startDateTime=2022-01-01T00%3A00%3A00&aggregateHours=24&location=Washington%2CDC%2CUSA&endDateTime=2019-01-03T00%3A00%3A00&unitGroup=us&dayStartTime=8%3A00%3A00&contentType=csv&dayEndTime=17%3A00%3A00&shortColumnNames=0",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => [
                "X-RapidAPI-Host: visual-crossing-weather.p.rapidapi.com",
                "X-RapidAPI-Key: 71ac94538emshf0b9e9bb7ba7d6fp1319b9jsn48cdb9f88a83"
            ],
        ]);

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo '';
        }

        $place = $request->request->get('city');
        $response = $this->client->request('GET', 'http://api.weatherapi.com/v1/forecast.json?key=e1b1fca996254d4f8b0174658222410&q=' . $place . '&days=5&aqi=yes&alerts=no');
        $data = $response->getContent();
        $jsonDecode = json_decode($data);
        $ImgWeather0Day = $jsonDecode->forecast->forecastday[0]->day->condition->icon;
        $ImgWeather1Day = $jsonDecode->forecast->forecastday[1]->day->condition->icon;
        $ImgWeather2Day = $jsonDecode->forecast->forecastday[2]->day->condition->icon;
        $ImgWeather3Day = $jsonDecode->forecast->forecastday[3]->day->condition->icon;
        $ImgWeather4Day = $jsonDecode->forecast->forecastday[4]->day->condition->icon;
        $powerWind = $jsonDecode->current->wind_mph;
        $temperatureNow = $jsonDecode->current->temp_c;
        $wetNow = $jsonDecode->current->humidity;
        $pressure = $jsonDecode->current->pressure_in;
        $weatherNow = $jsonDecode->current->condition->text;
        $address = $jsonDecode->location->name;
        $localtime = $jsonDecode->location->localtime;
        $days = $jsonDecode->forecast->forecastday;

        return $this->render('weather/weatherToday.twig', [
            'address' => $address,
            'ImgWeather0Day' => $ImgWeather0Day,
            'ImgWeather1Day' => $ImgWeather1Day,
            'ImgWeather2Day' => $ImgWeather2Day,
            'ImgWeather3Day' => $ImgWeather3Day,
            'ImgWeather4Day' => $ImgWeather4Day,
            'localtime' => $localtime,
            'days' => $days,
            'weather' => $weatherNow,
            'humidity' => $wetNow,
            'temp_c' => $temperatureNow,
            'pressure' => $pressure,
            'winSpeed' => $powerWind
        ]);
    }
    #[Route('/weather', name: 'displayHome')]
    public function displayHome(): Response
    {
        return $this->render('weather/homePage.html.twig');
    }
}