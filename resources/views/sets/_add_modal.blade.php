<div id="add-set-modal" class="modal modal-fixed-footer">
  <form class="form-horizontal" role="form" method="POST" action="{{ route('sets.store') }}">
  <div class="modal-content">
    {{ csrf_field() }}

    <h4>{{ trans('sets.add') }}</h4>
    <p>
      @include('sets._form_fields')
    </p>
  </div>
  <div class="modal-footer">
    <input type="submit" class=" modal-action modal-close waves-effect waves-green btn-flat" value="{{ trans('form.save') }}"/>
  </div>
  </form>
</div>