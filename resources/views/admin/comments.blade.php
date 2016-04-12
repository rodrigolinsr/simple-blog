@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <h2>Comments</h2>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <ul class="nav nav-tabs">
      <li role="presentation" class="{{ !isset($status) ? "active" : "" }}"><a href="{{ action('Admin\CommentsController@index') }}">All</a></li>
      <li role="presentation" class="{{ isset($status) && $status == 'pending' ? "active" : "" }}"><a href="{{ action('Admin\CommentsController@index', ['status' => 'pending']) }}">Pending&nbsp;&nbsp;<span class="label label-warning">{{ $counters['pending'] }}</span></a></li>
      <li role="presentation" class="{{ isset($status) && $status == 'approved' ? "active" : "" }}"><a href="{{ action('Admin\CommentsController@index', ['status' => 'approved']) }}">Approved&nbsp;&nbsp;<span class="label label-primary">{{ $counters['approved'] }}</span></a></li>
      <li role="presentation" class="dropdown pull-right">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Mass Actions <span class="caret"></span></a>
        <ul class="dropdown-menu">
          @if(!isset($status) || $status == 'pending')
          <li><a href="javascript:;" onclick="massModerateComments('{{ action('Admin\CommentsController@massApprove') }}', '{{ csrf_token() }}')"><i class="fa fa-check fa-btn"></i>Approve</a></li>
          @endif
          <li><a href="javascript:;" onclick="massModerateComments('{{ action('Admin\CommentsController@massDestroy') }}', '{{ csrf_token() }}')"><i class="fa fa-trash fa-btn"></i>Delete</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>
<div class="row" style="margin-top: 10px;">
  <div class="col-md-12">
    <table class="table list-table table-striped table-bordered" id="table-records">
      <thead>
        <tr>
          <th width="30"><input type="checkbox" class="check-all" /></th>
          <th>Post</th>
          <th>Name</th>
          <th>Email</th>
          <th>Comment</th>
          <th width="100">Date Sent</th>
          <th width="110">Status</th>
          <th width="140">Actions</th>
        </tr>
      </thead>
      <tbody>
      @if(!$comments->count())
        <tr>
          <td colspan="100" align="center">No records to display.</td>
        </tr>
      @else
        @foreach($comments as $key => $comment)
          <tr>
            <td><input type="checkbox" value="{{ $comment->_id }}" /></td>
            <td class="auto-break-words"><a href="{{ action('IndexController@viewPost', ['id' => $comment->post->_id]) }}" target="_blank">{{ $comment->post->title }}</a></td>
            <td>{{ $comment->name }}</td>
            <td>{{ $comment->email }}</td>
            <td>{{ $comment->comment }}</td>
            <td>{{ $comment->created_at ?? "-" }}</td>
            <td>
              @if($comment->pending)
                <span class="label label-default"><i class="fa fa-clock-o"></i> Pending</span>
              @else
                <span class="label label-success"><i class="fa fa-check-square-o"></i> Approved</span>
              @endif
            </td>
            <td>
              <div class="btn-group btn-group-xs" role="group" aria-label="Action buttons">
                @if($comment->pending)
                  <a href="{{ action('Admin\CommentsController@approve', ['id' => $comment->_id]) }}" class="btn btn-success">Approve</a>
                @endif
                <a href="javascript:;" class="btn btn-danger delete-record">Delete</a>
              </div>
              {!! @Form::open([
                'action' => ['Admin\CommentsController@destroy', id => $comment->_id],
                'method' => 'get'
              ]) !!}
              {!! Form::close() !!}
            </td>
          </tr>
        @endforeach
      @endif
      </tbody>
    </table>
    {!! $comments->appends(Input::except('page'))->links() !!}
  </div>
</div>
@include('admin.common.confirmmodal')
@endsection

@section('bottomScripts')
  <script src="{{ url('js/delete-record-confirm.js') }}"></script>
  <script src="{{ url('js/mass-action-records.js') }}"></script>
  <script>
    $('input[type="checkbox"].check-all').click(function() {
      var allChecked = $(this).get(0).checked;

      $(this).closest('table').find('input[type="checkbox"]').not('.check-all').each(function() {
        $(this).get(0).checked = allChecked;
      });
    });
  </script>
@endsection
