<div class="row">
  <div class="input-field col s6">
    <input name="when" required id="when" type="date" class="validate datepicker" value="{{ old('when', $nextSunday->format('j F, Y')) }}"  />
    <label for="when">{{ trans('sets.date') }} *</label>
  </div>
  <div class="input-field col s6">
    @include('services._select', ['services' => $services])
    <label>Service</label>
  </div>
</div>
<div class="row">
  
</div>

<div class="row">
  <div class="input-field col s12">
    <input name="title" id="title" type="text" class="validate" value="{{ old('title', $firstServiceTitle) }}" />
    <label for="title">{{ trans('sets.title') }}</label>
  </div>
</div>

<div class="row">
  <div class="input-field col s12">
    <textarea name="description" id="description" class="materialize-textarea">{{ old('description') }}</textarea>
    <label for="description">{{ trans('sets.description') }}</label>
  </div>
</div>

