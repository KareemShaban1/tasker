<?php

namespace App\Modules\City\Database\Factories;

use App\Models\User;
use App\Modules\City\Models\City;
use App\Modules\Country\Models\Country;
use App\Modules\Language\Models\Language;
use App\Modules\TaskType\Models\TaskType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    public $model = City::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence,
            'country_id' => Country::factory(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

   
}
