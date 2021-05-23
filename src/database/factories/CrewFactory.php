<?php

namespace Database\Factories;

use App\Models\Crew;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrewFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crew::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->name(),
            'en_title' => $this->faker->name(),
            'img' => 'test.png',
            'description' => $this->faker->text,
            'user_id' => User::factory()->create()->id,
        ];
    }
}
