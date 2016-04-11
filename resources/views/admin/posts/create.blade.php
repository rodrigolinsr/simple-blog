@extends('layouts.app')

@section('content')
<h2>Add new Post</h2>


@include('admin.posts.form', [
  'formTag' => Form::open([
    'action' => 'Admin\PostsController@store'
  ])
])

@endsection
