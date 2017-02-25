@extends('layouts.public')

@section('content')
<div class="container">
<div class="section">
    <div class="row">
        <div class="col m10 offset-m1">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">Reset Password</div>
                    @if (session('status'))
                        <div class="card-panel light-green lighten-4">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                        {{ csrf_field() }}

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row">
                            <div class="input-field col m12">
                                <input id="email" type="email" class="form-control" name="email" value="{{ $email or old('email') }}" required autofocus/>
                                <label for="email" class="col md4 ">E-Mail Address</label>

                                @if ($errors->has('email'))
                                    <span class=" card-panel ">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m12">
                                <input id="password" type="password" class="form-control" name="password" required/>
                                <label for="password" class="col md4 ">Password</label>

                                @if ($errors->has('password'))
                                    <span class=" card-panel ">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m12">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required/>
                                <label for="password-confirm" class="col-md-4 control-label">Confirm Password</label>
                                @if ($errors->has('password_confirmation'))
                                    <span class="card-panel ">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field col m12">
                                <div class="">
                                    <button type="submit" class="btn">
                                        Reset Password
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
