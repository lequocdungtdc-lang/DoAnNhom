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
            UserSeeder::class,

            CategorySeeder::class,
            ArtistSeeder::class,
            SampleDataSeeder::class,
            PlanSeeder::class,
            SubscriptionSeeder::class,
            SongSeeder::class,
            PodcastSeeder::class,
            CommentSeeder::class,
        ]);
    }
}
