<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->name();
        return [
            'name' =>  $name,
            'slug' => Str::slug($name),
            'short_description' => $this->faker->sentence(),
            'description' => $this->faker->paragraph(),
            'regular_price' => $this->faker->randomNumber(3),
            'sale_price' => $this->faker->randomNumber(2),
            'shipping_fee' => $this->faker->randomNumber(2),
            'category_id' => 1,
            'subcategory_id' => 1, //$this->faker->numberBetween(1,10),
            'image' => $this->faker->image('public/storage/products',640,600, null, false),





        ];
    }
}
