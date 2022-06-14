<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;

class SubcategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        
        return [
            'category_id' => $this->faker->numberBetween( 1,10),
            'name' =>  $this->faker->unique->name(),
            
        ];
    }
}
