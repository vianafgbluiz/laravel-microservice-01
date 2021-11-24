<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory()->create(),
            'name' => $this->faker->unique()->name(),
            'email' => $this->faker->unique()->email(),
            'whatsapp' => $this->faker->unique()->numberBetween(9000000000, 99999999999)
        ];
    }
}
