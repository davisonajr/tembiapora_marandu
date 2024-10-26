<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Country;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
        $countries = [
            ['hl' => 'es-419', 'gl' => 'AR', 'timezone_id' => 'America/Argentina/Buenos_Aires'],
            ['hl' => 'es-419', 'gl' => 'BO', 'timezone_id' => 'America/La_Paz'],
            ['hl' => 'pt-BR', 'gl' => 'BR', 'timezone_id' => 'America/Sao_Paulo'],
            ['hl' => 'es-419', 'gl' => 'CL', 'timezone_id' => 'America/Santiago'],
            ['hl' => 'es-419', 'gl' => 'CO', 'timezone_id' => 'America/Bogota'],
            ['hl' => 'es-419', 'gl' => 'CR', 'timezone_id' => 'America/Costa_Rica'],
            ['hl' => 'es-419', 'gl' => 'CU', 'timezone_id' => 'America/Havana'],
            ['hl' => 'es-419', 'gl' => 'EC', 'timezone_id' => 'America/Guayaquil'],
            ['hl' => 'es-419', 'gl' => 'SV', 'timezone_id' => 'America/El_Salvador'],
            ['hl' => 'es-419', 'gl' => 'GT', 'timezone_id' => 'America/Guatemala'],
            ['hl' => 'es-419', 'gl' => 'HT', 'timezone_id' => 'America/Port-au-Prince'],
            ['hl' => 'es-419', 'gl' => 'HN', 'timezone_id' => 'America/Tegucigalpa'],
            ['hl' => 'es-419', 'gl' => 'MX', 'timezone_id' => 'America/Mexico_City'],
            ['hl' => 'es-419', 'gl' => 'NI', 'timezone_id' => 'America/Managua'],
            ['hl' => 'es-419', 'gl' => 'PA', 'timezone_id' => 'America/Panama'],
            ['hl' => 'es-419', 'gl' => 'PY', 'timezone_id' => 'America/Asuncion'],
            ['hl' => 'es-419', 'gl' => 'PE', 'timezone_id' => 'America/Lima'],
            ['hl' => 'es-419', 'gl' => 'DO', 'timezone_id' => 'America/Santo_Domingo'],
            ['hl' => 'es-419', 'gl' => 'UY', 'timezone_id' => 'America/Montevideo'],
            ['hl' => 'es-419', 'gl' => 'VE', 'timezone_id' => 'America/Caracas'],
        ];

        foreach ($countries as $country) {
            Country::create($country);
        }
    }
}