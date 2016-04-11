<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\MyLib\BlogSettings;
use App\Models\{Post, Category, Tag};

class IndexController extends Controller
{
    protected function index()
    {
      $blogSettingsIni = BlogSettings::getSettings();

      /*
       * TODO:
       * 1) Rank tags
       * Nice to have: published_at
       */
      $posts = Post::where('draft', '=', false)->orderBy('updated_at', 'desc')->get();
      $categories = Category::all();
      $tags = Tag::all();

      return view('index')->with('welcomeTitle', $blogSettingsIni['welcome_title'])
                          ->with('welcomeMessage', $blogSettingsIni['welcome_message'])
                          ->with('posts', $posts)
                          ->with('categories', $categories)
                          ->with('tags', $tags);
    }
}
