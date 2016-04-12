<?php
namespace App\Models;

use Moloquent;

class Post extends Moloquent {
  /**
   * The attributes that are mass assignable.
   *
   * @var array
   */
  protected $fillable = ['title', 'text', 'draft', 'user_id'];

  protected $dates = ['published_at'];

  public function user() {
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
