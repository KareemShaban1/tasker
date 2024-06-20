<?php

namespace App\Modules\Specialty\Database\Factories;

use App\Models\User;
use App\Modules\Specialty\Models\Specialty;
use App\Modules\Language\Models\Language;
use App\Modules\TaskType\Models\TaskType;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends Factory<Specialty>
 */
class SpecialtyFactory extends Factory
{
    public $model = Specialty::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'is_active' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

   
}
