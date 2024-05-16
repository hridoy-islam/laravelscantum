<?php

namespace Database\Factories;

use App\Models\Brand;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
class BrandFactory extends Factory
{
    protected $model = Brand::class;

    public function definition()
    {
        $name = $faker->unique()->company;
        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'image' => $faker->imageUrl(),
        ];
    }
}
