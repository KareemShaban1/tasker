<?php

namespace App\Modules\TaskType\Database\Factories;

use App\Models\User;
use App\Modules\City\Models\City;
use App\Modules\Client\Models\Client;
use App\Modules\Country\Models\Country;
use App\Modules\TaskType\Models\TaskType;
use App\Modules\Language\Models\Language;
use App\Modules\State\Models\State;
use App\Modules\TaskTypeType\Models\TaskTypeType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends Factory<TaskType>
 */
class TaskTypeFactory extends Factory
{
    public $model = TaskType::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => $this->faker->sentence,
            'is_active' => $this->faker->boolean,
            'language_id' => Language::factory(),
            'location' => $this->faker->address,
            'country_id' => Country::factory(),
            'city_id' => City::factory(),
            'state_id' => State::factory(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

   
}
