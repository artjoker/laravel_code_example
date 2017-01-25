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

  $factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
      'name'           => $faker->name,
      'email'          => $faker->unique()->safeEmail,
      'password'       => $password ?: $password = bcrypt('123456'),
      'remember_token' => str_random(10),
    ];
  });

  $factory->define(App\Post::class, function (Faker\Generator $faker) {
    return [
      'userId' => rand(1, 5),
      'title'  => $faker->realText(100, 2),
      'body'   => $faker->paragraphs(5, true),
    ];
  });