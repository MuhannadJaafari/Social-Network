<?php

namespace Database\Factories;

use App\Models\HashtagsUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class HashtagsUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = HashtagsUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $type = [
            'App\Models\Post',
            'App\Models\Comment'
        ];
        $hashtagable_type = $type[rand(0, 1)];
        if ($hashtagable_type === $type[0]) {
            $hashtagable_id = rand(1, 25);
        } else {
            $hashtagable_id = rand(1, 500);
        }
        return [
            'hashtag_id' => rand(1, 7),
            'hashtagable_type' => $type[rand(0, 1)],
            'hashtagable_id' => $hashtagable_id
        ];
    }
}
