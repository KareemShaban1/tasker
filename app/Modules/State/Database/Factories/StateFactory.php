<?php

namespace App\Modules\State\Database\Factories;

use App\Models\User;
use App\Modules\City\Models\City;
use App\Modules\State\Models\State;
use App\Modules\Language\Models\Language;
use App\Modules\TaskType\Models\TaskType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends Factory<State>
 */
class StateFactory extends Factory
{
    public $model = State::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'city_id' => City::factory(),
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

   
}
