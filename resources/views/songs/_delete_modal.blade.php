<div id="delete-song-modal" class="modal">
  <div class="modal-content">
    {{ csrf_field() }}

    <h4>{{ __('songs.delete') }}</h4>
    <p>
      {{ __('songs.delete_are_you_sure') }}
    </p>
  </div>
  <div class="modal-footer">
    <button class=" waves-effect btn-flat" v-on:click="confirmDelete()">{{ __('common.delete') }}</button>
  </div>
  </form>
</div>