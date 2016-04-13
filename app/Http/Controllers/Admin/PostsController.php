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
    $posts = Post::orderBy('published_at', 'desc')->paginate($this->pageSize);
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

  /**
   * Create a new post
   *
   * @return \Illuminate\Http\Response
   */
  protected function store(Request $request) {
    $validator = $this->validator($request->all());
    if($validationResult = $this->validateEntity($request, $validator)) {
      return $validationResult;
    }

    $post = new Post;
    $this->setPostValues($post, $request);
    $post->save();

    $this->setPostCategories($post, $request);
    $this->setPostTags($post, $request);

    $this->addSuccessMessage($request, $this->getViewPostURL($post->_id));

    return redirect()->action('Admin\PostsController@edit', ['post' => $post->_id]);
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
          'title' => 'required_without:text|min:3|max:255',
          'text' => 'required_without:title|min:3',
      ]);
  }

  protected function setPostValues(Post $post, Request $request) {
    $post->title = $request->input('title');
    $post->text = $request->input('text');
    $post->draft = $request->input('btn_draft') ? true : false;
    $datePublished = new \DateTime($request->input('published_at'));
    if(!$request->input('published_at', null) && $request->input('btn_draft')) {
      // No date publish and saving as draft, clear the published_at
      $datePublished = null;
    }
    $post->published_at = $datePublished;
    $post->user_id = Auth::user()->id;
  }

  protected function setPostCategories(Post $post, Request $request) {
    $post->categories()->sync([]);
    foreach($request->input('categories', []) as $categoryId) {
      $category = Category::find($categoryId);
      $post->categories()->save($category);
    }
  }

  protected function setPostTags(Post $post, Request $request) {
    $post->tags()->sync([]);
    foreach($request->input('tags', []) as $tagId) {
      $tag = Tag::find($tagId);
      $post->tags()->save($tag);
    }
  }

  protected function addSuccessMessage(Request $request, string $postLink = null) {
    $service = new MessageService();

    $message = "";
    if($request->input('btn_draft')) {
      $message = "Post saved as draft";
    } else {
      $message = "Post saved";
    }
    if($postLink) {
      $message .= ". <a href='$postLink' target='_blank'>Click here</a> to view the post in blog";
    }

    $service->addMessage(MessageService::TYPE_SUCCESS, $message);
    $request->session()->flash('flashMessages', $service->getMessages());
  }

  protected function shareCategoriesAndTags() {
    $categories = Category::all();
    $tags = Tag::all();

    view()->share('categories', $categories);
    view()->share('tags', $tags);
  }

  protected function getViewPostURL($postId) {
    return action('IndexController@viewPost', ['id' => $postId]);
  }

  /**
   * Show the form to update a post
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  protected function edit(string $id) {
    $post = Post::find($id);
    if(!$post) {
      abort(404);
    }

    $this->shareCategoriesAndTags();
    return view('admin.posts.edit')->with('post', $post);
  }

  /**
   * Updates an existent post
   *
   * @return \Illuminate\Http\Response
   */
  protected function update(string $id, Request $request) {
    $validator = $this->validator($request->all());
    if($validationResult = $this->validateEntity($request, $validator)) {
      return $validationResult;
    }

    $post = Post::find($id);
    $this->setPostValues($post, $request);
    $post->save();

    $this->setPostCategories($post, $request);
    $this->setPostTags($post, $request);

    $this->addSuccessMessage($request, $this->getViewPostURL($post->_id));

    return redirect()->action('Admin\PostsController@edit', ['post' => $post->_id]);
  }

  /**
   * Deletes a post
   *
   * @return \Illuminate\Http\Response
   */
  protected function destroy(string $id, Request $request) {
    $post = Post::find($id);

    if(!$post) {
      abort(404);
    }

    $post->delete();

    $service = new MessageService();
    $service->addMessage(MessageService::TYPE_SUCCESS, "Post deleted");
    $request->session()->flash('flashMessages', $service->getMessages());
    return redirect()
            ->back();
  }
}
