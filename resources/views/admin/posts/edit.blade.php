@extends('layouts.app')

@section('content')
<h2>Edit Post</h2>

@include('admin.posts.form', [
  'formTag' => Form::open([
    'action' => ['Admin\PostsController@update', $post->_id],
    'method' => 'put'
  ]),
  'post' => $post
])
@endsection
