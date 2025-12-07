<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PictureFactory extends Factory
{
    protected $model = \App\Models\Picture::class;

    public function definition()
    {
   
        return [
            'url' => $this->faker->imageUrl(640, 640, 'people'),
            'position' => 0,
        ];
    }
}
