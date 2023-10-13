<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\WeatherData;

class WeatherController extends Controller
{

    public function getWeather(Request $request)
    {
        $apiKey = 'df735b8a20f4227282331b07a1f9f9ad';

        if ($request->has('selectedCity')) {
            $city = $request->input('selectedCity');
        } else {
            $city = 'Dnipro';
        }

        // проверяем в бд
        $weatherData = WeatherData::where('city', $city)->first();

        // сохраняем данные с api
        if (!$weatherData) {
            $weatherData = $this->fetchAndSaveWeatherData($apiKey, $city);
        }

        $ukCities = [
            'Berdiansk' => 'Бердянськ',
            'Bila Tserkva' => 'Біла Церква',
            'Boryspil' => 'Бориспіль',
            'Cherkasy' => 'Черкаси',
            'Chernihiv' => 'Чернігів',
            'Chernivtsi' => 'Чернівці',
            'Dnipro' => 'Дніпро',
            'Donetsk' => 'Донецьк',
            'Ivano-Frankivsk' => 'Івано-Франківськ',
            'Kamianske' => 'Кам\'янське',
            'Kharkiv' => 'Харків',
            'Kherson' => 'Херсон',
            'Khmelnytskyi' => 'Хмельницький',
            'Kiev' => 'Київ',
            'Kirovohrad' => 'Кіровоград',
            'Konotop' => 'Конотоп',
            'Kropyvnytskyi' => 'Кропивницький',
            'Luhansk' => 'Луганськ',
            'Lutsk' => 'Луцьк',
            'Lviv' => 'Львів',
            'Mariupol' => 'Маріуполь',
            'Melitopol' => 'Мелітополь',
            'Mukachevo' => 'Мукачево',
            'Mykolaiv' => 'Миколаїв',
            'Odesa' => 'Одеса',
            'Poltava' => 'Полтава',
            'Rivne' => 'Рівне',
            'Sevastopol' => 'Севастополь',
            'Simferopol' => 'Сімферополь',
            'Sumy' => 'Суми',
            'Ternopil' => 'Тернопіль',
            'Uzhhorod' => 'Ужгород',
            'Vinnytsia' => 'Вінниця',
            'Zaporizhzhia' => 'Запоріжжя',
            'Zhytomyr' => 'Житомир',
        ];

        return view('weather', [
            'weatherData' => $weatherData,
            'ukCities' => $ukCities,
            'selectedCity' => $city,
        ]);
    }


    private function fetchAndSaveWeatherData($apiKey, $city)
    {
        $days = 50; // дней проноза
        $lang = 'ua'; // язык

        $client = new Client();
        $response = $client->get("https://api.openweathermap.org/data/2.5/forecast?q={$city}&cnt={$days}&units=metric&appid={$apiKey}&lang={$lang}");
        $data = json_decode($response->getBody());

        // создаем новые записи в бд
        $weatherData = new WeatherData();
        $weatherData->city = $city;
        $weatherData->country = $data->city->country;
        $weatherData->temperature = round($data->list[0]->main->temp);
        $weatherData->weather_icon = $data->list[0]->weather[0]->icon;
        $weatherData->max_temperature = round($data->list[0]->main->temp_max);
        $weatherData->min_temperature = round($data->list[0]->main->temp_min);
        $hourlyTemperatures = [];


        foreach ($data->list as $hourlyData) {
            $hourlyTemperatures[] = [
                'time' => date('H:i', strtotime($hourlyData->dt_txt)),
                'temperature' => round($hourlyData->main->temp),
            ];
        }

        $weatherData->hourly_temperatures = $hourlyTemperatures;
        $weatherData->save();

        return $weatherData;
    }

}



