<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch REST API
        $response = Http::withHeaders([
            // API RAJA ONGKIR
            'key' => config('services.rajaongkir.key'),
        ])->get('https://api.rajaongkir.com/starter/city');
        // Loop data from REST API
        foreach($response['rajaongkir']['results'] as $city) {
            // Insert to table "cities"
            City::create([
                'province_id' => $city['province_id'],
                'city_id' => $city['city_id'],
                'name' => $city['city_name'] . ' - ' . '('. $city['type'] .')',
            ]);
        }
    }
}
