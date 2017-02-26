
@if(Session::has('alert-success'))
    <div class="alert-box card-panel light-green lighten-4">
        {{ Session::get('alert-success') }}
    </div>
@endif
@if(Session::has('alert-failure'))
    <div class="alert-box card-panel red lighten-2">
        {{ Session::get('alert-failure') }}
    </div>
@endif