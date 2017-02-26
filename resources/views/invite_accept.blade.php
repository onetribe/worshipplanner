@extends('layouts.public')

@section('content')
<div class="container">
<div class="section">
  <div class="row">
    <div class="card col m8 offset-m2">
      <div class="card-content">
        <h1>{{ __('teams.youve_been_invited', ['team_name' => $team->title]) }}</h1>
        <form role="form" method="POST" action="{{ route('invite.accept.confirm', ['team' => $team, 'email' => $email, 'token' => $token]) }}">
        {{ csrf_field() }}
        @unless($userExists)
          @include('auth._user_register_fields')
        @endunless
        <div class="row">
          <div class="col s12">
            <button type="submit" class="btn btn-primary">
              {{ __('teams.accept_invite') }}
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
