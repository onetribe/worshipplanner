  <div class="card ">
    <div class="card-content">
      <p><b>{{ __('sets.description') }}:</b> <br/><em>{{ $set->description }} </em></p>
      <p><b>{{ __('common.service') }}:</b>
        {{ $set->service ? $set->service->title : ""}}
      </p>
      <p><b>{{ __('sets.date') }}:</b> 
        {{ $set->when ? $set->when->format('j F, Y') : "" }}
      </p>
    </div>
  </div>