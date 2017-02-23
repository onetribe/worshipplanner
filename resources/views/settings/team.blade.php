@extends('layouts.app')

@section('menu_items')
    
@endsection

@section('content')
<div class="section" id="team-settings">
  <div class="row">
    <div class="col s12">
      
        <ul class="tabs">
          <li class="tab col s2">
            <a v-on:click="selectTab('team_members')" class="active" href="#team_members">{{ __('settings.team_members') }}</a>
            </li>
          <li class="tab col s2">
            <a v-on:click="selectTab('bands')" href="#bands">{{ __('settings.bands') }}</a>
          </li>
          <li class="tab col s2">
            <a v-on:click="selectTab('services')" href="#services">{{ __('settings.services') }}</a>
          </li>
          <li class="tab col s2">
            <a v-on:click="selectTab('authors')" href="#authors">{{ __('settings.authors') }}</a>
          </li>
          <li class="tab col s2">
            <a v-on:click="selectTab('band_roles')" href="#band_roles">{{ __('settings.band_roles') }}</a>
          </li>
        </ul>
      
    </div>
  </div>
  <div class="row">
    <div class="col s12">
      
          <div id="team_members" class="col s12" v-if="selectedTab == 'team_members'">
            <h4 class="card-title hide-on-med-and-up">{{ __('settings.team_members') }}</h4>
            <manageteammembers 
              :index-url="teamSubscriptionsIndexUrl" 
              :change-role-url="teamSubscriptionsChangeRoleUrl" 
              :remove-url="teamSubscriptionsRemoveUrl" 
              :user-id="userId" 
              :dictionary="teamMembershipDictionary"/>
          
          </div>
          <div id="bands" class="col s12" v-if="selectedTab == 'bands'">
            <h4 class="card-title hide-on-med-and-up">{{ __('settings.bands') }}</h4>
            <managebands
              :index-url="bandsIndexUrl" 
              :add-url="bandsAddUrl" 
              :remove-url="bandsRemoveUrl" 
              :band-roles-index-url="bandRolesIndexUrl" 
              :add-user-to-band-url="addUserToBandUrl" 
              :remove-user-from-band-url="removeUserFromBandUrl" 
              :users-index-url="usersIndexUrl" 
              :dictionary="bandsDictionary"/>
          </div>
          <div id="services" class="col s12" v-if="selectedTab == 'services'">
            <h4 class="card-title hide-on-med-and-up">{{ __('settings.services') }}</h4>
            <manageservices
              :index-url="servicesIndexUrl" 
              :add-url="servicesAddUrl" 
              :remove-url="servicesRemoveUrl" 
              :dictionary="servicesDictionary"/>
          </div>
          <div id="authors" class="col s12" v-if="selectedTab == 'authors'">
            <h4 class="card-title hide-on-med-and-up">{{ __('settings.authors') }}</h4>
            <manageauthors
              :index-url="authorsIndexUrl" 
              :add-url="authorsAddUrl" 
              :remove-url="authorsRemoveUrl" 
              :dictionary="authorsDictionary"/>
          </div>
          <div id="band_roles" class="col s12" v-if="selectedTab == 'band_roles'">
            <h4 class="card-title hide-on-med-and-up">{{ __('settings.band_roles') }}</h4>
            <managebandroles
              :index-url="bandRolesIndexUrl" 
              :add-url="bandRolesAddUrl" 
              :remove-url="bandRolesRemoveUrl" 
              :dictionary="bandRolesDictionary"/>
          </div>
        
        
    </div>
  </div>
</div>

@endsection

@section('scripts')
<script type="text/javascript">
var teamSubscriptionsIndexUrl = "{{ route('team_subscriptions.index', ['include' => 'user']) }}";
var teamSubscriptionsRemoveUrl = "{{ route('team_subscriptions.membership.remove', ['user' => '']) }}";
var teamSubscriptionsChangeRoleUrl = "{{ route('team_subscriptions.change_role', ['user' => '']) }}";
var teamMembershipDictionary = {
  'name': '{{ __('teams.name') }}',
  'role': '{{ __('teams.role') }}',
  'remove': '{{ __('teams.remove') }}',
  'make_admin': '{{ __('teams.make_admin') }}',
  'remove_admin': '{{ __('teams.remove_admin') }}',
  'invite': '{{ __('teams.invite') }}',
  'invite_member': '{{ __('teams.invite_member') }}',
  'email': '{{ __('form.email') }}',
};
var userId = {{ Auth::user()->id }};


var servicesIndexUrl = "{{ route('services.index') }}";
var servicesRemoveUrl = "{{ route('services.delete', ['service' => '']) }}";
var servicesAddUrl = "{{ route('services.store') }}";
var servicesDictionary = {
  'create_new': '{{ __('services.create_new') }}',
  'delete': '{{ __('common.delete') }}',
  'title': '{{ __('services.title') }}',
  'save': '{{ __('form.save') }}',
  'please_add_title': '{{ __('services.please_add_title') }}'  
};
var authorsIndexUrl = "{{ route('authors.index') }}";
var authorsRemoveUrl = "{{ route('authors.delete', ['author' => '']) }}";
var authorsAddUrl = "{{ route('authors.store') }}";
var authorsDictionary = {
  'create_new': '{{ __('authors.create_new') }}',
  'delete': '{{ __('common.delete') }}',
  'first_name': '{{ __('form.first_name') }}',
  'middle_name': '{{ __('form.middle_name') }}',
  'last_name': '{{ __('form.last_name') }}',
  'save': '{{ __('form.save') }}',
  'please_add_first_name': '{{ __('validation.required', ['attribute' => trans('form.first_name')]) }}',
};

var bandRolesIndexUrl = "{{ route('band_roles.index') }}";
var bandRolesRemoveUrl = "{{ route('band_roles.delete', ['bandRole' => '']) }}";
var bandRolesAddUrl = "{{ route('band_roles.store') }}";
var bandRolesDictionary = {
  'create_new': '{{ __('band_roles.create_new') }}',
  'delete': '{{ __('common.delete') }}',
  'title': '{{ __('band_roles.title') }}',
  'save': '{{ __('form.save') }}',
  'please_add_title': '{{ __('validation.required', ['attribute' => trans('form.title')]) }}'  
};

var usersIndexUrl = "{{ route('users.index') }}";
var bandsIndexUrl = "{{ route('bands.index', ['include' => 'bandSubscriptions,bandSubscriptions.user,bandSubscriptions.bandRoles']) }}";
var bandsRemoveUrl = "{{ route('bands.delete', ['bandRole' => '']) }}";
var bandsAddUrl = "{{ route('bands.store') }}";
var addUserToBandUrl = "{{ route('bands.user.add', ['band' => 'bandId', 'user' => 'userId']) }}";
var removeUserFromBandUrl = "{{ route('bands.user.remove', ['band' => 'bandId', 'user' => 'userId']) }}";
var bandsDictionary = {
  'create_new': '{{ __('bands.create_new') }}',
  'delete': '{{ __('common.delete') }}',
  'title': '{{ __('bands.title') }}',
  'save': '{{ __('form.save') }}',
  'please_add_title': '{{ __('bands.please_add_title') }}',
  'normally_plays': '{{ __('bands.normally_plays') }}',
  'member': '{{ __('bands.member') }}',
  'select_band_role': '{{ __('band_roles.select_band_role') }}',
  'add_user': '{{ __('common.add_user') }}'
};

var userSettings = new Vue({
    el: '#team-settings',
    data: {
      selectedTab: "team_members",
      teamSubscriptionsIndexUrl: teamSubscriptionsIndexUrl,
      teamSubscriptionsChangeRoleUrl: teamSubscriptionsChangeRoleUrl,
      teamSubscriptionsRemoveUrl: teamSubscriptionsRemoveUrl,
      teamMembershipDictionary: teamMembershipDictionary,
      servicesIndexUrl: servicesIndexUrl,
      servicesRemoveUrl: servicesRemoveUrl,
      servicesAddUrl: servicesAddUrl,
      servicesDictionary: servicesDictionary,
      authorsIndexUrl: authorsIndexUrl,
      authorsRemoveUrl: authorsRemoveUrl,
      authorsAddUrl: authorsAddUrl,
      authorsDictionary: authorsDictionary,
      bandRolesIndexUrl: bandRolesIndexUrl,
      bandRolesRemoveUrl: bandRolesRemoveUrl,
      bandRolesAddUrl: bandRolesAddUrl,
      bandRolesDictionary: bandRolesDictionary,
      bandsIndexUrl: bandsIndexUrl,
      bandsRemoveUrl: bandsRemoveUrl,
      bandsAddUrl: bandsAddUrl,
      addUserToBandUrl: addUserToBandUrl,
      removeUserFromBandUrl: removeUserFromBandUrl,
      usersIndexUrl: usersIndexUrl,
      bandsDictionary: bandsDictionary,
      userId: userId
    },
    components: {
      manageteammembers,
      manageservices,
      manageauthors,
      managebandroles,
      managebands
    },
    methods: {
      selectTab: function (tabName) {
        this.selectedTab = tabName;
      }
    },
    mounted: function () {
    }
});


</script>
@endsection
