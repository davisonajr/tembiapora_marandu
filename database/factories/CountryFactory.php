<?php

namespace Database\Factories;

use App\Models\Country;
use Illuminate\Database\Eloquent\Factories\Factory;

class CountryFactory extends Factory
{
    protected $model = Country::class;

    public function definition()
    {
        return [
            'gl' => $this->faker->randomElement(['AR', 'BO', 'BR', 'CL', 'CO', 'MX', 'PE', 'VE']),
            'hl' => $this->faker->randomElement(['es-419', 'pt-BR']),
            'timezone_id' => $this->faker->timezone,
        ];
    }
}