  <div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
              <i class="fa fa-user fa-btn"></i>Information</div>
            <div class="panel-body">
              {{ $formTag }}
              <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">Name</label>

                <div class="col-md-6">
                    <input type="text" class="form-control" name="name" value="{{ old('name', $user->name ?? "") }}">
                    @if ($errors->has('name'))
                        <span class="help-block">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                <label class="col-md-4 control-label">E-Mail Address</label>
                <div class="col-md-6">
                    <input type="email" class="form-control" name="email" value="{{ old('email', $user->email ?? "") }}"
                    {{ isset($user) ? "readonly='readonly'" : "" }}>

                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                </div>
              </div>

              <?php
                $hideChangePasswordButton = false;
                if($errors->has('password') || $errors->has('password_confirmation')) {
                  $hideChangePasswordButton = true;
                }
              ?>
              <div class="form-group {{ $hideChangePasswordButton ? "hide" : "" }}" id="change-password">
                <div class="col-md-4"></div>
                <div class="col-md-6">
                  <button class="btn btn-warning" type="button">
                    <i class="fa fa-key fa-btn"></i>Change password</button>
                </div>
              </div>

              <div id="password-fields" class="{{ !$hideChangePasswordButton ? "hide" : "" }}">
                <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Password</label>
                  <div class="col-md-6">
                      <input type="password" class="form-control" name="password">

                      @if ($errors->has('password'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>

                <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                  <label class="col-md-4 control-label">Confirm Password</label>
                  <div class="col-md-6">
                      <input type="password" class="form-control" name="password_confirmation">

                      @if ($errors->has('password_confirmation'))
                          <span class="help-block">
                              <strong>{{ $errors->first('password_confirmation') }}</strong>
                          </span>
                      @endif
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-footer" align="right">
              <a href="{{ action('Admin\UsersController@index') }}" class="btn btn-default">
                  <i class="fa fa-btn fa-times"></i>Cancel
              </a>
              <button type="submit" class="btn btn-primary">
                  <i class="fa fa-btn fa-floppy-o"></i>Save
              </button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
  </div>

@section('bottomScripts')
<script>
  $('#change-password button').click(function() {
    $('#password-fields').removeClass('hide');
    $('#change-password').hide();
  });
</script>
@endsection
