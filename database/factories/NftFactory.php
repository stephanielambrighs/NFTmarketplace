<?php

namespace Database\Factories;

use App\Models\Nft;
use Illuminate\Database\Eloquent\Factories\Factory;

class NftFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Nft::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'title' => $this->faker->name(),
            'creator' => $this->faker->name(),
            'description' => $this->faker->realText(100, 2),
            'collection_id' => $this->faker->numberBetween(1, 5),
            'owner_id' => $this->faker->numberBetween(3, 5),
            'image_file_path' => $this->faker->randomElement(['https://res.cloudinary.com/dqelbnq5n/image/upload/v1634481475/default_odqauf.png', 'https://res.cloudinary.com/dqelbnq5n/image/upload/v1634481475/default_odqauf.png']),
            'price' => $this->faker->numberBetween(75, 400)
        ];
    }
}
