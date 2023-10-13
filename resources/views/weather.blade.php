<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Weather Ukraine</title>
</head>
<body>


<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Погода в Україні') }}
        </h2>
    </x-slot>

<section class="vh-100" style="background-color: #C1CFEA;">
    <div class="container">
        <div class="row d-flex justify-content-center align-items-center h-100" style="color: #282828;">
            <div class="col-md-9 col-lg-7 col-xl-5 pt-5">
                <!-- Форма для выбора города -->
                <form id="getWeather" method="post" action="{{ route('getWeather') }}">
                    @csrf

                    <div class="form-group mb-4">
                        {{--<h1 class="text-center mb-3" for="selectedCity">Выберите город:</h1>--}}
                        <select class="form-select form-select-lg" id="selectedCity" name="selectedCity">
                            @foreach($ukCities as $englishCity => $ukCity)
                                <option value="{{ $englishCity }}" {{ $selectedCity === $englishCity ? 'selected' : '' }}>{{ $ukCity }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                    <div class="card mb-4 gradient-custom" style="border-radius: 25px;overflow: hidden;box-shadow: 0 5px 15px #999;">
                        <div class="card-body p-4" style="box-shadow: 0 5px 15px #999; overflow: hidden;">
                        <div id="demo1" class="carousel slide" data-ride="carousel">
                            <!-- Carousel inner -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-between mb-4 pb-2">
                                        <div>
                                            @if ($weatherData)
                                                <h2 class="display-2"><strong>{{ round($weatherData->temperature) }}°C</strong></h2>
                                                <p class="text-muted mb-0">{{ $weatherData->city }} / {{ $weatherData->country }}</p>
                                            @else
                                                <p>Данные о погоде недоступны.</p>
                                            @endif
                                        </div>
                                        <div>
                                            @if ($weatherData && $weatherData->weather_icon)
                                                <img src="https://openweathermap.org/img/wn/{{ $weatherData->weather_icon }}@2x.png" width="150px">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mb-4 gradient-custom" style="border-radius: 25px;overflow: hidden;box-shadow: 0 5px 15px #999;">
                    <div class="card-body p-4" style="box-shadow: 0 5px 15px #999; overflow: hidden;">

                        <div id="demo2" class="carousel slide" data-ride="carousel">
                            <!-- Carousel inner -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-around text-center mb-4 pb-3 pt-2">
                                        @if ($weatherData && is_array($weatherData->hourly_temperatures))
                                            <div class="d-flex justify-content-around text-center mb-4 pb-3 pt-2">
                                                @php $count = 0 @endphp
                                                @foreach ($weatherData->hourly_temperatures as $hourlyData)
                                                    @if ($count < 11)
                                                        <div class="flex-column">
                                                            @if ($weatherData->weather_icon)
                                                                <img src="https://openweathermap.org/img/wn/{{ $weatherData->weather_icon }}@2x.png" width="50px">
                                                            @endif
                                                            <p class="small">{{ $hourlyData['temperature'] }}°C</p>
                                                            <p class="mb-0">{{ $hourlyData['time'] }}</p>
                                                        </div>
                                                        @php $count++ @endphp
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>

                <div class="card mb-4 gradient-custom" style="border-radius: 25px;overflow: hidden;box-shadow: 0 5px 15px #999;">
                    <div class="card-body p-4" style="box-shadow: 0 5px 15px #999; overflow: hidden;">
                        <div id="demo3" class="carousel slide" data-ride="carousel">
                            <!-- Carousel inner -->
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-around text-center mb-4 pb-3 pt-2">
                                        @if (isset($weatherData->hourly_temperatures))
                                            @php
                                                $hourlyData = ($weatherData->hourly_temperatures);
                                                $currentDate = date('Y-m-d');
                                                $daysRendered = 0;
                                            @endphp
                                                @while ($daysRendered < 7)
                                                    @foreach ($hourlyData as $hourData)
                                                        @if ($hourData['time'] === "12:00")
                                                        <div class="flex-column">
                                                            <p class="mb-0">{{ date('d.m', strtotime($currentDate)) }}</p>
                                                            <p class="small">{{ $hourData['temperature'] }}°C</p>
                                                            @if ($weatherData->weather_icon)
                                                                <img src="https://openweathermap.org/img/wn/{{ $weatherData->weather_icon }}@2x.png" width="50px">
                                                            @endif
                                                        </div>
                                                            @php
                                                                $currentDate = date('Y-m-d', strtotime($currentDate. ' + 1 day'));
                                                                $daysRendered++;
                                                            @endphp
                                                        @endif
                                                    @endforeach
                                                @endwhile
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    document.getElementById("selectedCity").addEventListener("change", function() {
        document.getElementById("getWeather").submit();
    });
</script>
</x-app-layout>
</body>
</html>
