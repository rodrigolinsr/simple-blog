@extends('layouts.app')

@section('content')
<div class="row">
    <div class="col-md-12">
        <h1>Dashboard</h1>
        <div class="row">
          <div class="col-md-6">
            <div class="panel panel-primary">
              <div class="panel-heading">General Settings</div>

              <form role="form" method="post" action="{{ action('Admin\DashboardController@saveSettings') }}">
                {!! csrf_field() !!}

                <div class="panel-body">
                  <div class="form-group{{ $errors->has('blog_title') ? ' has-error' : '' }}">
                    <label for="blog-title">Blog title</label>
                    <input type="text" class="form-control" name="blog_title" id="blog-title"
                      value="{{ old('blog_title', $blogSettings['blog_title']) }}">
                    @if ($errors->has('blog_title'))
                      <span class="help-block">
                        <strong>{{ $errors->first('blog_title') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('blog_description') ? ' has-error' : '' }}">
                    <label for="blog-description">Blog description</label>
                    <input type="text" class="form-control" name="blog_description" id="blog-description"
                      value="{{ old('blog_description', $blogSettings['blog_description']) }}">
                    @if ($errors->has('blog_description'))
                      <span class="help-block">
                        <strong>{{ $errors->first('blog_description') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('welcome_title') ? ' has-error' : '' }}">
                    <label for="welcome-title">Welcome title</label>
                    <input type="text" class="form-control" name="welcome_title" id="welcome-title"
                      value="{{ old('welcome_title', $blogSettings['welcome_title']) }}">
                    @if ($errors->has('welcome_title'))
                      <span class="help-block">
                        <strong>{{ $errors->first('welcome_title') }}</strong>
                      </span>
                    @endif
                  </div>
                  <div class="form-group{{ $errors->has('welcome_message') ? ' has-error' : '' }}">
                    <label for="welcome-message">Welcome message</label>
                    <textarea class="form-control" rows="4" name="welcome_message" id="welcome-message">{{ old('welcome_message', $blogSettings['welcome_message']) }}</textarea>
                    @if ($errors->has('welcome_message'))
                      <span class="help-block">
                        <strong>{{ $errors->first('welcome_message') }}</strong>
                      </span>
                    @endif
                  </div>
                </div>
                <div class="panel-footer">
                  <button class="btn btn-primary">Save Settings</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-6">
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-info">
                  <div class="panel-heading">Statistics</div>
                  <div class="panel-body now-panel">
                    <div class="row">
                      <div class="col-md-6"><i class="fa fa-thumb-tack"></i> <a href="{{ url('/admin/posts') }}">{{$blogCounters['posts']}} posts</a></div>
                      <div class="col-md-6"><i class="fa fa-list"></i> <a href="{{ url('/admin/categories') }}">{{$blogCounters['categories']}} categories</a></div>
                    </div>
                    <div class="row">
                      <div class="col-md-6"><i class="fa fa-comments"></i> <a href="{{ url('/admin/comments') }}">{{$blogCounters['comments']}} comments</a></div>
                      <div class="col-md-6"><i class="fa fa-tags"></i> <a href="{{ url('/admin/tags') }}">{{$blogCounters['tags']}} tags</a></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="panel panel-info">
                  <div class="panel-heading">Quick Draft</div>

                  <form role="form" method="post" action="{{ action('Admin\DashboardController@savePostAsDraft') }}">
                    {!! csrf_field() !!}

                    <div class="panel-body">
                      <div class="form-group{{ $errors->has('post_title') ? ' has-error' : '' }}">
                        <input type="text" class="form-control" placeholder="Title" name="post_title" id="post-title" value="{{ old('post_title') }}">
                        @if ($errors->has('post_title'))
                          <span class="help-block">
                            <strong>{{ $errors->first('post_title') }}</strong>
                          </span>
                        @endif
                      </div>
                      <div class="form-group{{ $errors->has('post_text') ? ' has-error' : '' }}">
                        <textarea class="form-control" placeholder="What are you thinking now?" rows="4" name="post_text" id="post-message">{{ old('post_text') }}</textarea>
                        @if ($errors->has('post_text'))
                          <span class="help-block">
                            <strong>{{ $errors->first('post_text') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>
                    <div class="panel-footer">
                      <button class="btn btn-info">Save as draft</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
    </div>
</div>
@endsection
