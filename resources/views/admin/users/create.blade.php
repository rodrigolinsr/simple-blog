@extends('layouts.app')

@section('content')
@include('admin.common.createeditheader', [
  'title' => 'Add new User',
  'backLink' => action('Admin\UsersController@index'),
  'section' => 'Users'
])


@include('admin.users.form', [
  'formTag' => Form::open([
    'action' => 'Admin\UsersController@store',
    'class' => 'form-horizontal'
  ])
])

@endsection
