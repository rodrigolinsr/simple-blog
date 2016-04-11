<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\MyLib\BlogSettings;
use App\MyLib\MessageService;

use Input;
use Validator;
use Auth;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\PostComment;
use App\Models\Category;
use App\Models\Tag;
use App\Models\User;

class PostsController extends Controller
{
  /**
   * Show the list of posts.
   *
   * @return \Illuminate\Http\Response
   */
  protected function index() {
    $posts = Post::all();
    return view('admin.posts.index')->with('posts', $posts);
  }

  /**
   * Show the form to create a new post
   *
   * @return \Illuminate\Http\Response
   */
  protected function create() {
    return view('admin.posts.create');
  }

  /**
   * Create a new post
   *
   * @return \Illuminate\Http\Response
   */
  protected function store(Request $request) {
    $validator = $this->validator($request->all());

    $service = new MessageService();

    if($result = $this->redirectBackIfValidatorFails($validator)) {
      $service->addMessage(MessageService::TYPE_ERROR, "Please, check the data you've submitted and try again.");
      $request->session()->flash('flashMessages', $service->getMessages());

      return $result;
    }

    $post = new Post;
    $post->title = $request->input('title');
    $post->text = $request->input('text');
    // $post->draft = true;
    $post->author_id = Auth::user()->id;

    $post->save();

    $service->addMessage(MessageService::TYPE_SUCCESS, "Post saved successfully");
    $request->session()->flash('flashMessages', $service->getMessages());

    return redirect()->action('Admin\PostsController@edit', ['id' => $post->_id]);
  }

  /**
   * Get a validator for an incoming post request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
      return Validator::make($data, [
          'title' => 'required_without:text|min:3|max:100',
          'text' => 'required_without:title|min:3',
      ]);
  }



  /**
   * Show the form to update a post
   *
   * @return \Illuminate\Http\Response
   */
  protected function edit() {
    return 'form will be displayed';
  }

  /**
   * Updates an existent post
   *
   * @return \Illuminate\Http\Response
   */
  protected function update() {
    return 'post will be updated';
  }

  /**
   * Deletes a post
   *
   * @return \Illuminate\Http\Response
   */
  protected function destroy() {
    return 'post will be updated';
  }
}
