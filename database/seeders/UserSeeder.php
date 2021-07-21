<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Hashtag;
use App\Models\Like;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\RelationUser;
use App\Models\Text;
use App\Models\Users\Address;
use App\Models\Users\User;
use App\Models\Users\Username;
use App\Models\Video;
use Illuminate\Database\Eloquent\Relations\Relation;
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
                ->has(Comment::factory()->count(20)->state(function (array $attributes, Post $post) {
                    return ['user_id' => $post['postable_id']];
                }))
                ->has(Like::factory()->count(10)->state(function (array $attributes, Post $post) {
                    return ['user_id' => $post['postable_id']];
                }))
                ->has(Photo::factory()->count(rand(1, 4)))
                ->has(Video::factory()->count(rand(1, 4)))
                ->count(5)
            )
            ->has(Username::factory()->count(1))
            ->has(Address::factory()->count(1))
//            ->hasAttached(Page::factory()->count(rand(1,3)))
            ->create();
    }
}
