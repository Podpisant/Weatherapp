<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    protected $table = 'weather_data';

    protected $fillable = [
        'city',
        'country',
        'temperature',
        'weather_icon',
        'max_temperature',
        'min_temperature',
        'hourly_temperatures',
    ];

    protected $casts = [
        'hourly_temperatures' => 'json',
    ];
}
