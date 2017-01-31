<div id="add-song-modal" class="modal modal-fixed-footer">
  <form role="form" method="POST" action="{{ route('songs.store') }}">
  <div class="modal-content">
    {{ csrf_field() }}

    <h4>{{ __('songs.add') }}</h4>
    <p>
      @include('songs._basic_form_fields')
    </p>
  </div>
  <div class="modal-footer">
    <input type="submit" class=" modal-action modal-close waves-effect waves-green btn-flat" value="{{ __('form.save') }}"/>
  </div>
  </form>
</div>