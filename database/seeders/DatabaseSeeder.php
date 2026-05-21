<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            SampleDataSeeder::class,
            PlanSeeder::class,
            SubscriptionSeeder::class,
            SongSeeder::class,
                PodcastSeeder::class,
                UserSeeder::class,
                NewsSeeder::class,
                AdSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
