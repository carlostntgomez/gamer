<?php

namespace Database\Factories;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(5, 10));
        $published = $this->faker->boolean(80);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'content' => $this->faker->paragraphs(rand(5, 10), true),
            'excerpt' => $this->faker->paragraph(rand(2, 4)),
            'published_at' => $published ? $this->faker->dateTimeBetween('-1 year', 'now') : null,
            'user_id' => User::factory(), // This will create a new user if not explicitly passed
            'seo_title' => $this->faker->realText(60),
            'seo_description' => $this->faker->realText(160),
            'seo_keywords' => json_encode($this->faker->words(5)),
        ];
    }

    /**
     * Indicate that the post is published.
     */
    public function published(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ]);
    }

    /**
     * Indicate that the post is a draft.
     */
    public function draft(): Factory
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => null,
        ]);
    }
}
