<?php

namespace App\Modules\Client\Database\Factories;


use App\Modules\City\Models\City;
use App\Modules\Client\Models\Client;
use App\Modules\Country\Models\Country;
use App\Modules\State\Models\State;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/** 
 * @extends Factory<Client>
 */
class ClientFactory extends Factory
{
    public $model = Client::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'phone' => $this->faker->unique()->phoneNumber,
            'specialties' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'source' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'deleted_by' => null,
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
