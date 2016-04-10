<?php

namespace App\Models;

use Moloquent;

class Tag extends Moloquent {
  public function posts() {
    return $this->belongsToMany(Post::class);
  }
}
