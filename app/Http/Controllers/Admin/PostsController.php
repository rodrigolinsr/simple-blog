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
    $this->shareCategoriesAndTags();
    return view('admin.posts.create');
  }

  public function validatePost(Request $request) {
    $validator = $this->validator($request->all());

    if($result = $this->redirectBackIfValidatorFails($validator)) {
      $service = new MessageService();
      $service->addMessage(MessageService::TYPE_ERROR, "Please, check the data you've submitted and try again.");
      $request->session()->flash('flashMessages', $service->getMessages());

      return $result;
    }

    return null;
  }

  /**
   * Create a new post
   *
   * @return \Illuminate\Http\Response
   */
  protected function store(Request $request) {
    if($validationResult = $this->validatePost($request)) {
      return $validationResult;
    }

    $post = new Post;
    $this->setPostValues($post, $request);
    $post->save();

    $this->setPostCategories($post, $request);
    $this->setPostTags($post, $request);

    $this->addSuccessMessage($request);

    return redirect()->action('Admin\PostsController@edit', ['posts' => $post->_id]);
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

  protected function setPostValues(Post $post, Request $request) {
    $post->title = $request->input('title');
    $post->text = $request->input('text');
    $post->draft = $request->input('btn_draft') ? true : false;
    $post->author_id = Auth::user()->id;
  }

  protected function setPostCategories(Post $post, Request $request) {
    foreach($request->input('categories') as $categoryId) {
      $category = Category::find($categoryId);
      $post->categories()->save($category);
    }
  }

  protected function setPostTags(Post $post, Request $request) {
    foreach($request->input('tags') as $tagId) {
      $tag = Tag::find($tagId);
      $post->tags()->save($tag);
    }
  }

  protected function addSuccessMessage(Request $request) {
    $service = new MessageService();
    $message = $request->input('btn_draft') ? "Post saved as draft" : "Post saved";
    $service->addMessage(MessageService::TYPE_SUCCESS, $message);
    $request->session()->flash('flashMessages', $service->getMessages());
  }

  protected function shareCategoriesAndTags() {
    $categories = Category::all();
    $tags = Tag::all();

    view()->share('categories', $categories);
    view()->share('tags', $tags);
  }

  /**
   * Show the form to update a post
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  protected function edit(string $id) {
    $post = Post::find($id);
    $this->shareCategoriesAndTags();
    return view('admin.posts.edit')->with('post', $post);
  }

  /**
   * Updates an existent post
   *
   * @return \Illuminate\Http\Response
   */
  protected function update(string $id, Request $request) {
    if($validationResult = $this->validatePost($request)) {
      return $validationResult;
    }

    $post = Post::find($id);
    $this->setPostValues($post, $request);
    $post->save();

    $this->setPostCategories($post, $request);
    $this->setPostTags($post, $request);


    $this->addSuccessMessage($request);

    return redirect()->action('Admin\PostsController@edit', ['posts' => $post->_id]);
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
