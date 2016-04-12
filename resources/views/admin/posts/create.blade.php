@extends('layouts.app')

@section('content')
@include('admin.common.createeditheader', [
  'title' => 'Add new Post',
  'backLink' => action('Admin\PostsController@index'),
  'section' => 'Posts'
])


@include('admin.posts.form', [
  'formTag' => Form::open([
    'action' => 'Admin\PostsController@store'
  ])
])

@endsection
