<?php

namespace App\Modules\Offer\Database\Factories;


use App\Modules\Offer\Models\Offer;
use App\Modules\Language\Models\Language;
use App\Modules\TaskType\Models\TaskType;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends Factory<Offer>
 */
class OfferFactory extends Factory
{
    public $model = Offer::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'task_type_id' => TaskType::factory(),
            'offer' => $this->faker->randomFloat(2, 100, 1000), // Generates a random float between 100 and 1000
            'description' => $this->faker->sentence,
            'offer_limit' => $this->faker->word,
            'is_active' => $this->faker->boolean,
            'language_id' => Language::factory(),
            'created_by' => User::factory(),
            'updated_by' => User::factory(),
            'deleted_by' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

   
}
