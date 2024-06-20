<?php

namespace App\Modules\Category\Database\Factories;

use App\Modules\Category\Models\Category;
use App\Modules\Language\Models\Language;
use App\Modules\TaskType\Models\TaskType;
use App\Modules\User\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    public $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
          'name' => $this->faker->sentence,
            'parent_id' => Category::factory()->create(),
            'task_type_id' => TaskType::factory()->create(),
            'is_active' => $this->faker->boolean,
            'language_id' => Language::factory()->create(),
            'created_by' => User::factory()->create(),
            'updated_by' => User::factory()->create(),
            'deleted_by' => null,
            'created_at' => now(),
            'updated_at' => now(),
            'deleted_at' => null,
        ];
    }

   
}
