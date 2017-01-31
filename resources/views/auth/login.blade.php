@extends('layouts.login')

@section('content')

<div class="login-bg">
  <div class="section">
    <div class="row">
      <div class="col s10 m6 offset-m3">
        
          <div class="card z-depth-1">
            <div class="card-content">
              <span class="card-title">{{ __('auth.login') }}</span>
              <p>
                <form class="" role="form" method="POST" action="{{ url('/login') }}">
                    {{ csrf_field() }}

                    <div class="row">
                      <div class="input-field col s12">
                        <input name="email" id="email" type="email" class="validate" data-error="wrong" data-success="right" value="{{ old('email') }}" required autofocus/>
                        <label for="email">{{ __('form.email') }}</label>
                        @if ($errors->has('email'))
                          <span class="text-red">
                            <strong>{{ $errors->first('email') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>

                    <div class="row">
                      <div class="input-field col s12">
                        <input name="password" id="password" type="password" class="validate" required />
                        <label for="password">{{ __('form.password') }}</label>
                        @if ($errors->has('password'))
                          <span class="text-red">
                              <strong>{{ $errors->first('password') }}</strong>
                          </span>
                        @endif
                      </div>
                    </div>

                    <div class="row">
                      <div class="switch">
                        <label>
                          <input type="checkbox" name="remember">
                          <span class="lever"></span>
                          {{ __('auth.remember_me') }}
                        </label>
                      </div>
                    </div>


                    <div class="row">
                      <div class="col s12">
                        <button type="submit" class="btn btn-primary">
                          {{ __('auth.login') }}
                        </button>

                        <a class="btn btn-link" href="{{ url('/password/reset') }}">
                          {{ __('auth.forgot_password') }}
                        </a>
                      </div>
                    </div>
                    
                </form>
              </p>
            </div>
          </div>
        
      </div>
    </div>
  </div>
</div>
@endsection
