<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

use App\MyLib\{BlogSettings, Utils, MessageService};
use App\Models\{Post, Category, Tag, PostComment};
use Validator;

class IndexController extends Controller
{
  protected function index() {
    $blogSettingsIni = BlogSettings::getSettings();

    $posts = Post::where('draft', '=', false)
                 ->where('published_at', '<=', new \DateTime())
                 ->orderBy('published_at', 'desc')->paginate($this->pageSize);

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

    return view('viewpost')->with('post', $post)
                           ->with('customPageTitle', $post->title." | ");
  }

  protected function postComment(string $postId, Request $request) {
    $post = Post::find($postId);

    if(!$post) {
      abort(404);
    }

    $validator = $this->commentValidator($request->all());
    if($validationResult = $this->validateEntity($request, $validator)) {
      return $validationResult;
    }

    $comment = new PostComment($request->except('_token'));
    $comment->pending = true;
    $post->comments()->save($comment);

    $service = new MessageService();
    $service->addMessage(MessageService::TYPE_SUCCESS, "Your comment has been sent and will be approved by the administrator.");
    $request->session()->flash('flashMessages', $service->getMessages());
    return redirect()
            ->back();
  }

  /**
   * Get a validator for an incoming add comment request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function commentValidator(array $data)
  {
    return Validator::make($data, [
      'name' => 'required|max:255',
      'email' => 'email|max:255',
      'comment' => 'required',
    ]);
  }

}
