<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;

use App\Http\Requests;

use App\Models\PostComment;
use App\MyLib\MessageService;

class CommentsController extends Controller {
  const MASS_APPROVE = 0;
  const MASS_DELETE = 1;

  /**
   * Show the list of comments.
   *
   * @return \Illuminate\Http\Response
   */
  protected function index(Request $request) {
    $comments = [];

    if($status = $request->get('status', null)) {
      if($status == 'pending') {
        $pending = true;
      } else if($status == 'approved') {
        $pending = false;
      }

      $comments = PostComment::where('pending', $pending)->orderBy('created_at', 'desc')->paginate($this->pageSize);
    } else {
      // Bring all results to paginate
      $comments = PostComment::orderBy('created_at', 'desc')->paginate($this->pageSize);
    }

    $counters = [
      'pending' => PostComment::where('pending', true)->count(),
      'approved' => PostComment::where('pending', false)->count(),
    ];

    $view = view('admin.comments')->with('comments', $comments)
                                  ->with('counters', $counters);
    if($status = $request->get('status', null)) {
      $view->with('status', $status);
    }
    return $view;
  }

  /**
   * Approves a comment
   *
   * @return \Illuminate\Http\Response
   */
  protected function approve(string $id, Request $request) {
    $comment = PostComment::find($id);

    if(!$comment) {
      abort(404);
    }

    $comment->pending = false;
    $comment->save();

    $service = new MessageService();
    $service->addMessage(MessageService::TYPE_SUCCESS, "Comment approved");
    $request->session()->flash('flashMessages', $service->getMessages());

    return redirect()
            ->back();
  }

  /**
   * Deletes a comment
   *
   * @return \Illuminate\Http\Response
   */
  protected function destroy(string $id, Request $request) {
    $comment = PostComment::find($id);

    if(!$comment) {
      abort(404);
    }

    $comment->delete();

    $service = new MessageService();
    $service->addMessage(MessageService::TYPE_SUCCESS, "Comment deleted");
    $request->session()->flash('flashMessages', $service->getMessages());

    return redirect()
            ->back();
  }

  /**
   * Mass approve comments
   *
   * @return \Illuminate\Http\Response
   */
  protected function massApprove(Request $request) {
    return $this->massModerateComments($request, self::MASS_APPROVE);
  }

  /**
   * Mass delete comments
   *
   * @return \Illuminate\Http\Response
   */
  protected function massDestroy(Request $request) {
    return $this->massModerateComments($request, self::MASS_DELETE);
  }

  protected function showMustSelectRecordsMessage(MessageService $service, Request $request) {
    $service->addMessage(MessageService::TYPE_ERROR, "You must select at least one record");
    $request->session()->flash('flashMessages', $service->getMessages());
  }

  protected function massModerateComments($request, $action) {
    $service = new MessageService();

    $commentsIds = $request->get('commentsIds');
    if(!count($commentsIds)) {
      $this->showMustSelectRecordsMessage($service, $request);
      return redirect()
              ->back();
    }

    if($action === self::MASS_DELETE) {
      PostComment::destroy($commentsIds);
    } else {
      $comments = PostComment::findMany($commentsIds);

      foreach($comments as $comment) {
          $comment->pending = false;
          $comment->save();
      }
    }

    $service->addMessage(MessageService::TYPE_SUCCESS, "Comments mass moderated");
    $request->session()->flash('flashMessages', $service->getMessages());

    return redirect()
            ->back();
  }
}
