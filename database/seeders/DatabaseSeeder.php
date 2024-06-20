<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Modules\Category\Models\Category;
use App\Modules\City\Models\City;
use App\Modules\Client\Models\Client;
use App\Modules\Country\Models\Country;
use App\Modules\Language\Models\Language;
use App\Modules\Offer\Models\Offer;
use App\Modules\Specialty\Models\Specialty;
use App\Modules\State\Models\State;
use App\Modules\Task\Models\Task;
use App\Modules\TaskType\Models\TaskType;
use App\Modules\User\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $this->call(UserSeeder::class);

        Category::factory()->count(10)->create();
        City::factory(10)->create();
        Client::factory(10)->create();
        Country::factory(10)->create();
        Language::factory(10)->create();
        Offer::factory(10)->create();
        Specialty::factory(10)->create();
        State::factory(10)->create();
        Task::factory(10)->create();
        TaskType::factory(10)->create();
        User::factory(10)->create();






        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
