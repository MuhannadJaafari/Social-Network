<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use App\Models\Users\User;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();
        $posts = Post::all();
        $comments = Comment::all();
        foreach ($users as $user) {
            foreach ($posts as $post) {
                $like = new Like();
                $like->user_id = $user->id;
                $post->likes()->save($like);
            }
            foreach ($comments as $comment) {
                $like = new Like();
                $like->user_id = $user->id;
                $comment->likes()->save($like);
            }
        }
    }
}
