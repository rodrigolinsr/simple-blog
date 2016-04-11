@extends('layouts.app')

@section('content')
<h2>Add new Post</h2>

@include('admin.posts.form', ['formAction' => action('Admin\PostsController@store'), 'formMethod' => 'post'])
@endsection
