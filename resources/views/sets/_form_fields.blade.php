<div class="row">
  <div class="input-field col s6">
    <input name="when" required id="when" type="text" class="validate datepicker" value="{{ empty($set) ? old('when', $nextSunday->format('j F, Y')) : $set->when->format('j F, Y') }}"  />
    <label for="when">{{ __('sets.date') }} *</label>
  </div>
  <div class="input-field col s6">
  
    @if(!empty($set) && $set->service)
      @include('services._select', ['services' => $services, 'selectedServiceId' => $set->service->id])
    @else    
      @include('services._select', ['services' => $services])
    @endif

    <label>{{ __('common.service') }}</label>
  </div>
</div>

<div class="row">
  <div class="input-field col s12">
    <input name="title" id="title" type="text" class="validate" value="{{ empty($set) ? old('title', $firstServiceTitle) : $set->title }}" />
    <label for="title">{{ __('sets.title') }}</label>
  </div>
</div>

<div class="row">
  <div class="input-field col s12">
    <textarea name="description" id="description" class="materialize-textarea">{{ empty($set) ? old('description') : $set->description }}</textarea>
    <label for="description">{{ __('sets.description') }}</label>
  </div>
</div>

