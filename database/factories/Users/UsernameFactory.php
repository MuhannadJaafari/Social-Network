<?php

namespace Database\Factories\Users;

use App\Models\Users\Username;
use Illuminate\Database\Eloquent\Factories\Factory;

class UsernameFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Username::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->userName
        ];
    }
}
