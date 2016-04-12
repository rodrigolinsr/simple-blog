<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\MyLib\{BlogSettings, Utils};
use App\Models\{Post, Category, Tag};

class IndexController extends Controller
{
  protected function index() {
    $blogSettingsIni = BlogSettings::getSettings();

    $posts = Post::where('draft', '=', false)
                 ->where('published_at', '<=', new \DateTime())
                 ->orderBy('published_at', 'desc')->get();

    foreach($posts as $post) {
      $post->truncatedText = Utils::printTruncated(1000, $post->text);
    }

    return view('index')->with('welcomeTitle', $blogSettingsIni['welcome_title'])
                        ->with('welcomeMessage', $blogSettingsIni['welcome_message'])
                        ->with('posts', $posts);
  }

  protected function viewPost(string $id, Request $request) {
    $post = Post::find($id);
    if(!$post) {
      abort(404);
    }

    return view('viewpost')->with('post', $post);
  }
}
