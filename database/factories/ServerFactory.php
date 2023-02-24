<?php

namespace Database\Factories;

use App\Models\Server;
use Illuminate\Database\Eloquent\Factories\Factory;

class ServerFactory extends Factory
{
    protected $model = Server::class;

    public function definition()
    {
        return [
            'name' => $this->faker->unique()->word(),
            'region' => $this->faker->unique()->word(),
        ];
    }
}
