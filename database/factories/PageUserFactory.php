<?php

namespace Database\Factories;

use App\Models\PageUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class PageUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PageUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'=>rand(1,5),
            'page_id'=>rand(1,6),
            'role'=>'member'
        ];
    }
}
