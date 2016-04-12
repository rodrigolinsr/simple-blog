<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;

use App\Models\PostComment;
use App\MyLib\MessageService;

class CommentsController extends Controller {
  /**
   * Show the list of comments.
   *
   * @return \Illuminate\Http\Response
   */
  protected function index() {
    $comments = PostComment::paginate($this->pageSize);
    return view('admin.comments')->with('comments', $comments);
  }

  /**
   * Approves a comment
   *
   * @return \Illuminate\Http\Response
   */
  protected function approve(string $id, Request $request) {
    return "approve comment";
  }

  /**
   * Deletes a comment
   *
   * @return \Illuminate\Http\Response
   */
  protected function destroy(Request $request) {
    return "delete comment";
  }
}
