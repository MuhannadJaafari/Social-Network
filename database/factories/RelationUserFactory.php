<?php

namespace Database\Factories;

use App\Models\RelationUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class RelationUserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RelationUser::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
//        $firstValue = rand(1, 5);
//        $secondValue = rand(1, 5);
//        while ($secondValue == $firstValue) {
//            $secondValue = rand(1, 5);
//        }
//        while (true){
//            $r = RelationUser::where('user1_id', $firstValue)->where('user2_id', $secondValue)->first();
//            if ($r) continue;
//            else {
//                $r = RelationUser::where('user2_id', $firstValue)->where('user1_id', $secondValue)->first();
//                if ($r) continue;
//                else break;
//            }
//        }
//        return [
//            'user1_id' => $firstValue,
//            'user2_id' => $secondValue,
//            'relation' => 'friends'
//        ];
    }
}
