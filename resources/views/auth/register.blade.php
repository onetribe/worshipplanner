@extends('layouts.public')

@section('content')
<div class="container">
  <div class="row">
    <div class="col s10 m8 offset-m2">

      <div class="card z-depth-1">
        <div class="card-content">
          <span class="card-title">{{trans('form.register_new_team_user')}}</span>
          <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}
            
            <div class="row">
              <div class="input-field col s12">
                <input id="team_title" type="text" class="form-control" name="team_title" value="{{ old('team_title') }}" required autofocus>
                <label for="team_title">{{ trans('form.team_name') }}</label>
                @if ($errors->has('team_title'))
                  <span class="text-red">
                    <strong>{{ $errors->first('team_title') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                @include("_country_codes", ['selectedCountry' => old('country_code', 'ZA')])
                <label for="country_code">{{ trans('form.country') }}</label>
                @if ($errors->has('country_code'))
                  <span class="text-red">
                    <strong>{{ $errors->first('country_code') }}</strong>
                  </span>
                @endif
              </div>
            </div>

            <div class="row">
              <div class="input-field col s12">
                <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
                <label for="first_name">{{ trans('form.first_name') }}</label>
                @if ($errors->has('first_name'))
                  <span class="text-red">
                    <strong>{{ $errors->first('first_name') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="last_name" type="text" name="last_name" value="{{ old('last_name') }}" required autofocus>
                <label for="last_name">{{ trans('form.last_name') }}</label>
                @if ($errors->has('last_name'))
                  <span class="text-red">
                    <strong>{{ $errors->first('last_name') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="email" type="text" name="email" value="{{ old('email') }}" required autofocus>
                <label for="email">{{ trans('form.email') }}</label>
                @if ($errors->has('email'))
                  <span class="text-red">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="password" type="password" name="password" required>
                <label for="password">{{ trans('form.password') }}</label>
                @if ($errors->has('password'))
                  <span class="text-red">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
            </div>
            <div class="row">
              <div class="input-field col s12">
                <input id="password-confirm" type="password" name="password_confirmation" required>
                <label for="password-confirm">{{ trans('form.confirm_password') }}</label>
              </div>
            </div>

            <div class="row">
              <div class="col s12">
                <button type="submit" class="btn btn-primary">
                  {{ trans('form.register') }}
                </button>
              </div>
            </div>

          </form>
        </div>



              
      </div>
    </div>
  </div>
</div>
@endsection
