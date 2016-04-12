@extends('layouts.app')

@section('content')
@include('admin.common.createeditheader', [
  'title' => 'Edit User',
  'backLink' => action('Admin\UsersController@index'),
  'section' => 'Users'
])

@include('admin.users.form', [
  'formTag' => Form::open([
    'action' => ['Admin\UsersController@update', $user->_id],
    'method' => 'put',
    'class' => 'form-horizontal'
  ]),
  'user' => $user
])
@endsection
