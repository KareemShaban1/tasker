<?php

namespace App\Modules\Task\Database\Factories;


use App\Modules\City\Models\City;
use App\Modules\Client\Models\Client;
use App\Modules\Country\Models\Country;
use App\Modules\Task\Models\Task;
use App\Modules\Language\Models\Language;
use App\Modules\State\Models\State;
use App\Modules\TaskType\Models\TaskType;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    public $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'source' => $this->faker->word,
            'image' => $this->faker->imageUrl(),
            'video' => $this->faker->url,
            'is_active' => $this->faker->boolean,
            'client_id' => Client::factory(),
            'language_id' => Language::factory(),
            'location' => $this->faker->address,
            'country_id' => Country::factory(),
            'city_id' => City::factory(),
            'state_id' => State::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'deleted_by' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

   
}
