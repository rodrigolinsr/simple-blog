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

      $user = new App\Models\User([
          'name' => 'Simple Blog Admin',
          'email' => 'admin@simpleblog.fake',
          'password' => bcrypt('p4ssw0rd'),
      ]);

      $user->save();
    }
}
