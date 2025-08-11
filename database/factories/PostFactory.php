<?php

namespace Database\Factories;
use App\Models\Category;
// use \Illuminate\Support\Str;

use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory {

    public function definition(): array {

        $title = fake()->sentence;
        return [
            'image' => fake()->imageUrl(),
            'title' => $title,
            'slug' => \Illuminate\Support\Str::slug($title),
            'content' => fake()->paragraphs(5, true), // true convierte array a string
            'category_id' => Category::inRandomOrder()->first()->id,
            'user_id' => 1,
            'published_at' => fake()->optional()->dateTime(),
        ];
    }
}
