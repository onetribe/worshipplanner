<div class="row">
  <div class="input-field col s12">
    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>
    <label for="first_name">{{ __('form.first_name') }}</label>
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
    <label for="last_name">{{ __('form.last_name') }}</label>
    @if ($errors->has('last_name'))
      <span class="red-text">
        <strong>{{ $errors->first('last_name') }}</strong>
      </span>
    @endif
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
    <input id="email" type="text" name="email" value="{{ old('email', !empty($email) ? $email : '') }}" required autofocus>
    <label for="email">{{ __('form.email') }}</label>
    @if ($errors->has('email'))
      <span class="red-text">
        <strong>{{ $errors->first('email') }}</strong>
      </span>
    @endif
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
    <input id="password" type="password" name="password" required>
    <label for="password">{{ __('form.password') }}</label>
    @if ($errors->has('password'))
      <span class="red-text">
        <strong>{{ $errors->first('password') }}</strong>
      </span>
    @endif
  </div>
</div>
<div class="row">
  <div class="input-field col s12">
    <input id="password-confirm" type="password" name="password_confirmation" required>
    <label for="password-confirm">{{ __('form.confirm_password') }}</label>
  </div>
</div>