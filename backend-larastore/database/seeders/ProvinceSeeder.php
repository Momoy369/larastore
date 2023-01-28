<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class ProvinceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Fetch Rest API
        $response = Http::withHeaders([
            // API KEY RAJAONGKIR
            'key' => config('services.rajaongkir.key'),
        ])->get('https://api.rajaongkir.com/starter/province');

        // Loop data from REST API
        foreach($response['rajaongkir']['results'] as $province){
            // Insert to table "Province"
            Province::create([
                'province_id' => $province['province_id'],
                'name' => $province['province']
            ]);
        }
    }
}
