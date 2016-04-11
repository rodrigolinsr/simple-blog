<?php

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
  /**
   * Run the database seeds.
   *
   * @return void
   */
  public function run()
  {
    DB::table('categories')->truncate();

    factory(App\Models\Category::class, 10)->create();
  }
}
