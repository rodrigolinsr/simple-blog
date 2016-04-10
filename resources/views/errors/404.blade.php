@extends('layouts.errors')

@section('title')
404 - Page not found
@endsection

@section('content')
<div class="title">404: Page not found.</div>
<div class="back-home"><a href="{{ url('/') }}">Back to Home</a></div>
@endsection
