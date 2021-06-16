<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Text;
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

//        $userFactory = User::factory()->count(3)->afterCreating(function(User $user){
//            dd($user);
//        })->create();


        User::factory()
            ->count(5)
            ->has(Post::factory()
                ->has(Comment::factory()->count(20)->state(function(array $attributes,Post $post){
                    return ['user_id'=>$post['postable_id']];
                }))

                ->count(5)
            )
            ->create();


    }
}
