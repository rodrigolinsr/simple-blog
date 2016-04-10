<?php
namespace App\Models;

use Moloquent;

class Post extends Moloquent
{
  public function author() {
    return $this->belongsTo(User::class);
  }

  public function categories() {
    return $this->belongsToMany(Category::class);
  }

  public function tags() {
    return $this->belongsToMany(Tag::class);
  }

  public function comments() {
    return $this->hasMany(PostComment::class);
  }
}
