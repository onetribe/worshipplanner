<select name="service_id">
  <option value="" disabled>{{ __('services.choose') }}</option>
  @foreach($services as $service)
    <option value="{{ $service->id }}" @if(!empty($selectedServiceId) && $selectedServiceId == $service->id) selected @endif>{{ $service->title }}</option>
  @endforeach
</select>