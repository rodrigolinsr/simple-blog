<?php

namespace App\Models;

use Moloquent;

class PostComment extends Moloquent {
  protected $collection = 'posts_comments';

  protected $fillable = ['post_id', 'name', 'email', 'comment', 'pending', 'created_at'];

  public function post() {
    return $this->belongsTo(Post::class);
  }
}
