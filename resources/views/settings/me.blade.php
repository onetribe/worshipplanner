@extends('layouts.app')

@section('menu_items')
    
@endsection

@section('content')
<div class="section" id="me">
  <div class="row">
    <div class="col s12">
      <div class="row">
        <div class="col s6">
          <div class="card-panel" id="user-settings" v-cloak>
            <h3>{{ __('common.profile') }}</h3>
            <wpform buttontext="{{ __('form.save') }}" :submitted="submitted" :errors="errors" :successmessage="successmessage">
              <div slot="elements">
                <div class="input-field col s12">
                  <input type="text" name="first_name" id="first_name" class="validate" v-model="user.first_name"/>
                  <label for="first_name">{{ __('form.first_name') }} *</label>
                </div><div class="input-field col s12">
                  <input type="text" name="last_name" id="last_name" class="validate" v-model="user.last_name"/>
                  <label for="last_name">{{ __('form.last_name') }} *</label>
                </div>
                <div class="input-field col s12">
                  <input type="email" name="email" id="email" class="validate" v-model="user.email"/>
                  <label for="email">{{ __('form.email') }} *</label>
                </div>
                <h5>{{ __('security.update_password') }}</h5>
                <div class="input-field col s12">
                  <input type="password" name="current_password" id="current_password" class="validate" v-model="current_password"/>
                  <label for="current_password">{{ __('form.current_password') }}</label>
                </div>
                <div class="input-field col s12">
                  <input type="password" name="new_password" id="new_password" class="validate" v-model="new_password"/>
                  <label for="new_password">{{ __('form.new_password') }}</label>
                </div>
                <div class="input-field col s12">
                  <input id="password-confirm" type="password" name="new_password_confirmation" v-model="new_password_confirmation"/>
                  <label for="password-confirm">{{ __('form.confirm_password') }}</label>
                </div>
              </div>
            </wpform>
          </div>
        </div>

        <div class="col s6">
          <div class="card-panel" id="teams" v-cloak>
            <h3>{{ __('teams.my_teams') }}</h3>
              <div class="card-panel light-green lighten-4" v-if="successmessage">
                @{{ successmessage }}
              </div>
            <table>
              <tr v-for="team in user.team_subscriptions">
                <td>@{{ team.team.title }}</td>
                <td><button class="btn btn-flat" v-on:click="leave(team.team,'{{__('teams.leave_confirm')}}')">{{ __('teams.leave') }}</button></td>
              </tr>
            </table>
          </div>

          <div class="card-panel" id="my_involvement" v-cloak>
            <h3>{{ __('settings.my_involvement') }}</h3>
              <div class="card-panel light-green lighten-4" v-if="successmessage">
                @{{ successmessage }}
              </div>
            <p>

                <div class="input-field col s4" v-for="role in bandRoles">
                  <input type="checkbox" class="filled-in" :id="'role_'+role.id" v-on:click="toggleRole(role)" v-model="selectedRoles[role.id]"/>
                  <label :for="'role_'+role.id">@{{ role.title }}</label>
                </div>
                <div class="clearfix"></div>
            </p>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

@include('songs._add_modal')
@include('songs._delete_modal')
@endsection

@section('scripts')
<script type="text/javascript">
var user = {!! $user->toJson() !!};
var bandRoles = {!! $bandRoles->toJson() !!};
var updateUserUrl = "{{ route('users.update', ['user' => $user]) }}";
var leaveTeamUrl = "{{ route('teams.leave', ['team' => new \App\Team]) }}";
var bandRoleRemoveUrl = "{{ route('user.involvement.remove', ['user' => $user, 'bandRole' => new \App\BandRole]) }}";
var bandRoleAddUrl = "{{ route('user.involvement.add', ['user' => $user, 'bandRole' => new \App\BandRole]) }}";

var userSettings = new Vue({
    el: '#user-settings',
    data: {
        user: user,
        current_password: null,
        new_password: null,
        new_password_confirmation: null,
        errors: [],
        successmessage: ""
    },
    components: {
      wpform
    },
    methods: {
      submitted: function () {
        var data = {
          'first_name': this.user.first_name,
          'last_name': this.user.last_name,
          'email': this.user.email,
        };

        if (this.current_password) {
          data['current_password'] = this.current_password;  
          data['new_password'] = this.new_password;  
          data['new_password_confirmation'] = this.new_password_confirmation;  
        }

        this.$http.put(updateUserUrl, data).then(function(Response){
          this.successmessage = Response.body.meta.message;
          setTimeout(function () {
            this.successmessage = "";
          }.bind(this), 5000);
          this.current_password = this.new_password = this.new_password_confirmation = null;
        }, function(Response) {
          if (Response.status == 422) {
            var errors = [];
            for (var error in Response.body) {
              if (Response.body.hasOwnProperty(error)) {
                  errors.push(Response.body[error]);
              }
            }
            this.errors = errors;
          }
          
          setTimeout(function () {
            this.errors = [];
          }.bind(this), 5000);
        });
      }
    }
});

var teams = new Vue({
    el: '#teams',
    data: {
        user: user,
        successmessage: "",
    },
    methods: {
      leave: function (team, confirmationMessage) {
        if (!window.confirm(confirmationMessage)) {
          return;
        }

        this.$http.get(leaveTeamUrl + "/" + team.id).then(function (Response) {
          this.successmessage = Response.body.meta.message;
          for (var i = 0; i < this.user.team_subscriptions.length; i++) {
            if (team.id == this.user.team_subscriptions[i].team_id) {
               this.user.team_subscriptions.splice(i, 1);
            }
          }
          setTimeout(function () {
            this.successmessage = "";
          }.bind(this), 5000);
        }, function (Response) {

        });
      }
    }
});


var initialRoles = {};
for (var i = 0; i < bandRoles.length; i++) {
  initialRoles[bandRoles[i].id] = false;
  for (var j = 0; j < user.band_roles.length; j++) {
    if (user.band_roles[j].id == bandRoles[i].id) {
      initialRoles[bandRoles[i].id] = true;    
    }
  }
}
var my_involvement = new Vue({
    el: '#my_involvement',
    data: {
        'user': user,
        'bandRoles': bandRoles,
        'selectedRoles': initialRoles,
        'successmessage': "",
    },
    methods: {
      toggleRole: function (role) {
        if (!this.selectedRoles[role.id]) {
          this.$http.post(bandRoleAddUrl + "/" + role.id).then(function (Response) {
            this.successmessage = Response.body.meta.message;
          }, function (Response) {

          });
        } else {
          this.$http.delete(bandRoleRemoveUrl + "/" + role.id).then(function (Response) {
            this.successmessage = Response.body.meta.message;
          }, function (Response) {

          });
        }
      }
    }
});

</script>
@endsection
