{{--
required: $route
optional: $set
--}}

<div id="add-edit-set-modal" class="modal modal-fixed-footer">
  <form role="form" method="POST" action="{{ $route }}">
  <div class="modal-content">
    {{ csrf_field() }}

    <h4>{{ __('sets.add') }}</h4>
    <p>
      @if(empty($set))
        @include('sets._form_fields')
      @else
        @include('sets._form_fields', ['set' => $set])
      @endif
    </p>
  </div>
  <div class="modal-footer">
    <input type="submit" class=" modal-action modal-close waves-effect waves-green btn-flat" value="{{ __('form.save') }}"/>
  </div>
  </form>
</div>