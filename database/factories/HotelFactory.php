<?php

namespace Database\Factories;

use App\Models\Hotel;
use Illuminate\Database\Eloquent\Factories\Factory;

class HotelFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Hotel::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_name'=>  $this->faker->word,
            'vendor_name' =>  $this->faker->word,
            'sales'       =>  $this->faker->randomDigit,
            'price'       =>  $this->faker->randomDigit,
            'votes'       =>  $this->faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 4),
            'created_at'  =>  $this->faker->date('Y-m-d H:i:s'),
            'updated_at'  =>  $this->faker->date('Y-m-d H:i:s')
        ];
    }
}
