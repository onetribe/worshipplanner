@extends('layouts.public')

@section('content')
<div class="container">
  <div class="row">
    <div class="col s10 m8 offset-m2">
      <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                    {{ csrf_field() }}

      <div class="card z-depth-1">
        <div class="card-content">
          <span class="card-title">{{__('form.register_new_team_user')}}</span>
          
            
            <div class="row">
              <div class="input-field col s12">
                <input id="team_title" type="text" class="form-control" name="team_title" value="{{ old('team_title') }}" required autofocus>
                <label for="team_title">{{ __('form.team_name') }}</label>
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
                <label for="country_code">{{ __('form.country') }}</label>
                @if ($errors->has('country_code'))
                  <span class="text-red">
                    <strong>{{ $errors->first('country_code') }}</strong>
                  </span>
                @endif
              </div>
            </div>
        </div>
      </div>

      <div class="card">
        <div class="card-content">

          @include('auth._user_register_fields')

          <div class="row">
            <div class="col s12">
              <button type="submit" class="btn btn-primary">
                {{ __('form.register') }}
              </button>
            </div>
          </div>
        </div>
      </div>

      </form>
    </div>
  </div>
</div>
@endsection
