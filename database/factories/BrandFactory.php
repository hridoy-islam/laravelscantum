<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;

class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->company,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(), // Add the image field
        ];
    }
}
