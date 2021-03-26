<?php

namespace Database\Factories;

use App\Models\Job;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

class JobFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Job::class;

    /**
     * Define the model's default state.
     *
     * @return array
     * @throws Exception
     */
    public function definition(): array
    {
        if (random_int(0, 1) === 1) {
            $game = 'ETS2';
        } else {
            $game = 'ATS';
        }

        if (random_int(0, 1) === 1) {
            $description = $this->faker->paragraph;
        }

        return [
            'trucksbook_username' => $this->faker->userName,
            'trucksbook_id' => random_int(1, 20000),
            'game' => $game,
            'from' => $this->faker->city,
            'to' => $this->faker->city,
            'cargo' => $this->faker->word,
            'damage' => random_int(0, 100),
            'xp' => random_int(1, 1000),
            'profit' => random_int(100, 10000),
            'planned_distance' => ($planned_distance = random_int(100, 1000)),
            'driven_distance' => $planned_distance + random_int(-100, 500),
            'weight' => random_int(1000, 10000),
            'description' => $description ?? null,
        ];
    }
}
