@extends('layouts.app')

@section('content')
@include('admin.common.createeditheader', [
  'title' => 'Edit Post',
  'backLink' => action('Admin\PostsController@index'),
  'section' => 'Posts'
])

@include('admin.posts.form', [
  'formTag' => Form::open([
    'action' => ['Admin\PostsController@update', $post->_id],
    'method' => 'put'
  ]),
  'post' => $post
])
@endsection
