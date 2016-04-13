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

class DashboardController extends Controller
{
  /**
   * Show the administration dashboard.
   *
   * @return \Illuminate\Http\Response
   */
  protected function index() {
    $blogSettingsIni = BlogSettings::getSettings();

    $counters = [
      'posts' => Post::count(),
      'categories' => Category::count(),
      'comments' => PostComment::count(),
      'tags' => Tag::count(),
    ];

    return view('admin.index')->with('blogSettings', $blogSettingsIni)
                              ->with('blogCounters', $counters);
  }

  /**
   * Saves the blog settings
   *
   * @return \Illuminate\Http\Response
   */
  protected function saveSettings(Request $request) {
    $validator = $this->settingsValidator($request->all());

    $service = new MessageService();

    if($result = $this->redirectBackIfValidatorFails($validator)) {
      $service->addMessage(MessageService::TYPE_ERROR, "Please, check the data you've submitted and try again.");
      $request->session()->flash('flashMessages', $service->getMessages());

      return $result;
    }

    // Save the settings
    BlogSettings::setSettings($request->except('_token'));

    $service->addMessage(MessageService::TYPE_SUCCESS, "General Settings successfully saved.");
    $request->session()->flash('flashMessages', $service->getMessages());

    return redirect()->action('Admin\DashboardController@index');
  }

  /**
   * Get a validator for an incoming save settings request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function settingsValidator(array $data) {
    return Validator::make($data, [
      'blog_title' => 'required|min:3|max:40',
      'blog_description' => 'required|min:3|max:100'
    ]);
  }

  /**
   * Saves a post as a draft
   *
   * @return \Illuminate\Http\Response
   */
  protected function savePostAsDraft(Request $request) {
    $validator = $this->savePostAsDraftValidator($request->all());

    $service = new MessageService();

    if($result = $this->redirectBackIfValidatorFails($validator)) {
      $service->addMessage(MessageService::TYPE_ERROR, "Please, check the data you've submitted and try again.");
      $request->session()->flash('flashMessages', $service->getMessages());

      return $result;
    }

    $post = new Post;
    $post->title = $request->input('post_title');
    $post->text = $request->input('post_text');
    $post->draft = true;
    $post->user_id = Auth::user()->id;

    $post->save();

    $urlToPost = action('Admin\PostsController@edit', ['id' => $post->_id]);

    $service->addMessage(MessageService::TYPE_SUCCESS, "Post saved successfully as draft.
    <a href='$urlToPost'>Click here</a> to continue editing the post");
    $request->session()->flash('flashMessages', $service->getMessages());

    return redirect()->back();
  }

  /**
   * Get a validator for an incoming save post as draft request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function savePostAsDraftValidator(array $data) {
    return Validator::make($data, [
      'post_title' => 'required_without:post_text|min:3|max:100',
      'post_text' => 'required_without:post_title|min:3'
    ]);
  }
}
