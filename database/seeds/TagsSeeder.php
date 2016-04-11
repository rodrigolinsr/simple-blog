<?php

use Illuminate\Database\Seeder;

class TagsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('tags')->truncate();

    factory(App\Models\Tag::class, 15)->create();
  }
}
