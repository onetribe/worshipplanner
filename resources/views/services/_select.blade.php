<select>
  <option value="" disabled>{{ trans('services.choose') }}</option>
  @foreach($services as $service)
    <option value="{{ $service->id }}">{{ $service->title }}</option>
  @endforeach
</select>