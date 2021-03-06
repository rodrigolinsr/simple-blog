<?php

namespace App\Models;

use Moloquent;

class Category extends Moloquent {
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['name'];

  public function posts() {
    return $this->belongsToMany(Post::class);
  }
}
