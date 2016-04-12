@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="row">
      <div class="col-md-3">
        <h2>Users</h2>
      </div>
      <div class="col-md-6">
        <!-- <div class="input-group h2">
          <input name="data[search]" class="form-control" id="search" type="text" placeholder="Search items">
          <span class="input-group-btn">
            <button class="btn btn-primary" type="submit">
              <i class="fa fa-search"></i>
            </button>
          </span>
        </div> -->
      </div>
      <div class="col-md-3">
        <a href="{{ action('Admin\UsersController@create') }}" class="btn btn-primary pull-right h2">Add new User</a>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <table class="table list-table table-striped table-bordered no-margin">
          <thead>
            <tr>
              <th>Name</th>
              <th>Email</th>
              <th>Date Created</th>
              <th width="110">Actions</th>
            </tr>
          </thead>
          <tbody>
          @if(!$users->count())
            <tr>
              <td colspan="100" align="center">No records to display.</td>
            </tr>
          @else
            @foreach($users as $key => $user)
              <tr>
                <td class="auto-break-words"><a href="{{ action('Admin\UsersController@edit', ['id' => $user->_id]) }}">{{ $user->name }}</a></td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->created_at }}</td>
                <td>
                  <div class="btn-group btn-group-xs" role="group" aria-label="Action buttons">
                    <a href="{{ action('Admin\UsersController@edit', ['id' => $user->_id]) }}" class="btn btn-warning">Edit</a>
                    <a href="javascript:;" class="btn btn-danger delete-record">Delete</a>
                  </div>
                  {!! @Form::open([
                    'action' => ['Admin\UsersController@destroy', $user->_id],
                    'method' => 'delete'
                  ]) !!}
                  {!! Form::close() !!}
                </td>
              </tr>
            @endforeach
          @endif
          </tbody>
        </table>
        {!! $users->links() !!}
      </div>
    </div>
  </div>
</div>
@include('admin.common.confirmmodal', [
  'additionalMessage' => '<p class="text-warning"><strong>Warning: all posts of this user will be deleted!</strong></p>'
])
@endsection

@section('bottomScripts')
  <script src="{{ url('js/delete-record-confirm.js') }}"></script>
@endsection
