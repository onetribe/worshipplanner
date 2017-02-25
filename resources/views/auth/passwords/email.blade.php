@extends('layouts.public')

<!-- Main Content -->
@section('content')
<div class="container">
<div class="section">
    <div class="row">
        <div class="col m8 offset-m2">
            <div class="card">
                <div class="card-content">
                    <div class="card-title">Reset Password</div>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ url('/password/email') }}">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="input-field">
                                <div class="col m12">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required/>
                                    <label for="email" class="col-md-4 control-label">E-Mail Address</label>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="input-field">
                                <div class="col m6">
                                    <button type="submit" class="btn btn-primary">
                                        Send Password Reset Link
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
