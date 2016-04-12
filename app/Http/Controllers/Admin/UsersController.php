<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Validator;
use Auth;

use App\Http\Requests;

use App\Models\User;
use App\MyLib\MessageService;

class UsersController extends Controller {
  /**
   * Show the list of users.
   *
   * @return \Illuminate\Http\Response
   */
  protected function index() {
    $users = User::paginate($this->pageSize);
    return view('admin.users.index')->with('users', $users);
  }

  /**
   * Show the form to create a new user
   *
   * @return \Illuminate\Http\Response
   */
  protected function create() {
    return view('admin.users.create');
  }

  /**
   * Create a new user
   *
   * @return \Illuminate\Http\Response
   */
  protected function store(Request $request) {
    $validator = $this->createValidator($request->all());
    if($validationResult = $this->validateEntity($request, $validator)) {
      return $validationResult;
    }

    $user = new User;
    $this->setUserValues($user, $request);
    $user->save();

    $this->addSuccessMessage($request);

    return redirect()->action('Admin\UsersController@index');
  }

  protected function setUserValues(User $user, Request $request) {
    $user->name = $request->input('name');
    if(!isset($user->_id)) {
      $user->email = $request->input('email');
      $user->password = bcrypt($request->input('password'));
    } else {
      if($request->input('password', null)) {
        $user->password = bcrypt($request->input('password'));
      }
    }
  }

  protected function addSuccessMessage(Request $request) {
    $service = new MessageService();
    $service->addMessage(MessageService::TYPE_SUCCESS, "User saved");
    $request->session()->flash('flashMessages', $service->getMessages());
  }

  /**
   * Get a validator for an incoming create user request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function createValidator(array $data)
  {
      return Validator::make($data, [
          'name' => 'required|max:255',
          'email' => 'required|email|max:255|unique:users',
          'password' => 'required|min:6|confirmed',
      ]);
  }

  /**
   * Get a validator for an incoming update user request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function updateValidator(array $data)
  {
      return Validator::make($data, [
          'name' => 'required|max:255',
          'password' => 'min:6|confirmed',
      ]);
  }

  /**
   * Show the form to update a user
   *
   * @param  string  $id
   * @return \Illuminate\Http\Response
   */
  protected function edit(string $id) {
    $user = User::find($id);
    if(!$user) {
      abort(404);
    }

    return view('admin.users.edit')->with('user', $user);
  }

  /**
   * Updates an existent user
   *
   * @return \Illuminate\Http\Response
   */
  protected function update(string $id, Request $request) {
    $validator = $this->updateValidator($request->all());
    if($validationResult = $this->validateEntity($request, $validator)) {
      return $validationResult;
    }

    $user = User::find($id);
    $this->setUserValues($user, $request);
    $user->save();

    $this->addSuccessMessage($request);

    return redirect()->action('Admin\UsersController@index');
  }

  /**
   * Deletes a user
   *
   * @return \Illuminate\Http\Response
   */
  protected function destroy(string $id, Request $request) {
    $service = new MessageService();

    $user = User::find($id);

    if(!$user) {
      abort(404);
    }

    $errorMessage = null;
    if(User::count() == 1) {
      $errorMessage = "You must have at least one user to administrate the blog";
    } else if($user->_id == Auth::user()->id) {
      $errorMessage = "You cannot delete your own user";
    }

    if($errorMessage) {
      $service->addMessage(MessageService::TYPE_ERROR, $errorMessage);
      $request->session()->flash('flashMessages', $service->getMessages());
      return redirect()
              ->back();
    }

    $user->delete();

    $service->addMessage(MessageService::TYPE_SUCCESS, "User deleted");
    $request->session()->flash('flashMessages', $service->getMessages());
    return redirect()
            ->back();
  }
}
