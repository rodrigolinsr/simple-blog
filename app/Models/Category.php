<?php

namespace App\Models;

use Moloquent;

class Category extends Moloquent {
  public function posts() {
    return $this->belongsToMany(Post::class);
  }
}
