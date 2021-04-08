<?php

namespace Combindma\Carousel\Database\Factories;

use Combindma\Carousel\Models\Carousel;
use Illuminate\Database\Eloquent\Factories\Factory;

class CarouselFactory extends Factory
{
    protected $model = Carousel::class;

    public function definition()
    {
        return [
            'title' => $this->faker->words(10, true),
            'content' => $this->faker->sentence(1000),
            'description' => $this->faker->sentence(55),
            'published_at' => now(),
            'is_published' => $this->faker->boolean,
            'is_featured' => $this->faker->boolean,
            'meta' => [],
        ];
    }
}
