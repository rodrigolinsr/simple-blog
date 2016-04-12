@extends('layouts.app')

@section('content')
@include('admin.posts.createeditheader', ['title' => 'Edit Post'])

@include('admin.posts.form', [
  'formTag' => Form::open([
    'action' => ['Admin\PostsController@update', $post->_id],
    'method' => 'put'
  ]),
  'post' => $post
])
@endsection
