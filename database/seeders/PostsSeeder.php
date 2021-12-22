<?php

namespace Database\Seeders;

use App\Models\Post;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();

        for ($i=1; $i < 100; $i++) {
            Post::create([
                'name' => $faker->word(),
                'description' => $faker->text(),
                'date_published' => $faker->dateTime(),
                'is_active' => $faker->boolean()
            ]);
        }
    }
}
