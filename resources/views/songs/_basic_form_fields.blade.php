
<div class="row">
  <div class="input-field col s12">
    <input name="title" id="title" type="text" class="validate" value="{{ $defaultTitle or "" }}" />
    <label for="title">{{ __('songs.title') }} *</label>
  </div>
</div>

<div class="row">
  <div class="input-field col s12">
    <input name="alternative_title" id="alternative_title" type="text" class="validate" value="{{ $defaultAlternativeTitle or "" }}" />
    <label for="alternative_title">{{ __('songs.alternative_title') }}</label>
  </div>
</div>


