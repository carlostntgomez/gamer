<?php

namespace Database\Factories;

use App\Models\Author;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition()
    {
        $title = $this->faker->unique()->sentence(4);

        return [
            'user_id' => User::factory(),
            'author_id' => Author::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(3, true),
            'excerpt' => $this->faker->sentence,
            'published_at' => $this->faker->optional(0.8)->dateTimeBetween('-1 year', 'now'),
            'seo_title' => $title,
            'seo_description' => $this->faker->sentence,
            'seo_keywords' => $this->faker->words(5, true),
            'image_path' => null, // Will be handled by the seeder
        ];
    }
}
