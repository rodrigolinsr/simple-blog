<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'email' => $faker->safeEmail,
        'password' => bcrypt(str_random(10)),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    return [
        'name' => ucfirst($faker->word)
    ];
});

$factory->define(App\Models\Tag::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->word
    ];
});


$factory->define(App\Models\Post::class, function (Faker\Generator $faker) {
  return [
    'title' => $faker->sentence,
    'text' => nl2br($faker->paragraphs(10, true)),
    'draft' => $faker->boolean,
    'published_at' => $faker->dateTimeBetween('-2 month', '-1 week')
  ];
});

$factory->define(App\Models\PostComment::class, function (Faker\Generator $faker) {
  return [
    'name' => $faker->name,
    'email' => $faker->safeEmail,
    'comment' => $faker->text,
    'pending' => $faker->boolean,
    'created_at' => $faker->dateTimeBetween('-1 week', 'now')
  ];
});
