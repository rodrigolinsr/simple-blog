<?php

use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      DB::table('users')->truncate();
      DB::table('posts')->truncate();
      DB::table('posts_comments')->truncate();

      $user = new App\Models\User([
          'name' => 'Simple Blog Admin',
          'email' => 'admin@simpleblog.fake',
          'password' => bcrypt('p4ssw0rd'),
      ]);

      $user->save();

      factory(App\Models\User::class, 15)->create()->each(function($user) {
        $user->posts()->save(factory(App\Models\Post::class)->make());
        $user->posts()->each(function($post) {
          factory(App\Models\PostComment::class, rand(0,20))->make()->each(function($comment) use ($post) {
            $comment->post()->associate($post);
            $comment->save();
          });

        });
      });

      // $user->posts()->save(factory(App\Models\Post::class, rand(0,20))->create());
      // factory(App\Models\Post::class, 30)->create()->each(function($post) use ($user) {
      //   // $post->user()->save($user);
      //   // $post->comments()->save(factory(App\Models\PostComment::class, 10)->make());
      // });
    }
}
