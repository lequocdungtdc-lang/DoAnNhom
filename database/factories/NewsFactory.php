<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class NewsFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(8);
        return [
            'title'     => $title,
            'slug'      => Str::slug($title),
            'content'   => $this->faker->paragraphs(5, true),
            'summary'   => $this->faker->sentence(15),
            'category'  => $this->faker->randomElement(['Công nghệ', 'Xã hội', 'Kinh tế', 'Thể thao', 'Giáo dục']),
            'user_id'   => 1,
            'status'    => 'published',
            'views'     => rand(10, 500),
        ];
    }
}