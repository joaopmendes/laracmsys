<?php

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostSeeder::class);
        $this->call(TagSeeder::class);

        Auth::loginUsingId(User::first()->id);
        $post = Post::first();
        $post->tags()->sync([1, 2]);

        Comment::create([
            'user_id' => Auth::id(),
            'post_id' => $post->id,
            'body' => 'This is a comment',
        ]);
    }
}
