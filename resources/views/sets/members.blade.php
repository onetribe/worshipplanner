@extends('layouts.app')

@section('menu_items')
  <li>
      <a class="waves-effect waves-light tooltipped" 
         data-position="bottom" 
         data-delay="50" 
         data-tooltip="{{ __('sets.edit') }}" 
         href="{{ route('sets.edit', ['set' => $set]) }}"><i class="material-icons">skip_previous</i></a>
  </li>
  
@endsection

@section('content')
<div class="section" id="manage-set-members" v-cloak>


<div class="row">
<div class="col s6 m4 l3 card" v-for="role in band_roles">
  <div class="card-content">
    <span class="card-title">@{{ role.title }}</span>
    
    <select class="browser-default" v-on:change="userChanged(role.id, $event)" v-model="subscriptions[role.id]">
      <option value="">{{ __('bands.add_member') }}</option>
      <option v-for="user in users" :value="user.id">@{{ user.name }}</option>
    </select>
  </div>
</div>

</div>

</div>


@endsection



@section('scripts')
<script type="text/javascript">
var set = {!! $set->toJson() !!};
var band_roles = {!! $bandRoles->toJson() !!};
var bands = {!! $bands->toJson() !!};
var users = {!! $users->toJson() !!};
var setsUserAddRoleUrl = "{{ route('sets.user.role.add', ['set' => 'setId', 'user' => 'userId', 'bandRole' => 'bandRoleId']) }}";
var setsUserRemoveUrl = "{{ route('sets.role.remove', ['set' => 'setId', 'bandRole' => 'bandRoleId']) }}";
var subscriptions = {};

for (var i = 0; i < band_roles.length; i++) {
  subscriptions[band_roles[i].id] = "";
}
for (var i = 0; i < set.set_subscriptions.length; i++) {
  for (var j = 0; j < set.set_subscriptions[i].band_roles.length; j++) {
    subscriptions[set.set_subscriptions[i].band_roles[j].id] = set.set_subscriptions[i].user.id;
  }
}

app = new Vue({ 
  el: '#manage-set-members',
  data: {
      band_roles: band_roles,
      bands: bands,
      users: users,
      set: set,
      setsUserAddRoleUrl: setsUserAddRoleUrl,
      setsUserRemoveUrl: setsUserRemoveUrl,
      subscriptions: subscriptions,
  },
  computed: {
      
  },
  methods: {
      userChanged: function (roleId, e) {
        var userId = e.target.value;
        if (userId != "") {
          this.addUser(roleId, userId);
        } else {
          this.removeByRole(roleId);
        }
      },
      removeByRole: function (roleId) {
        var setsUserRemoveUrl = this.setsUserRemoveUrl.replace('bandRoleId', roleId).replace('setId', this.set.id);
        this.$http.delete(setsUserRemoveUrl).then(function (Response) {
          Materialize.toast(Response.body.meta.message, 2000, 'success');
        });
      },
      addUser: function (bandRoleId, userId) {
        
        var setsUserAddRoleUrl = this.setsUserAddRoleUrl.replace('userId', userId).replace('setId', this.set.id).replace('bandRoleId', bandRoleId);
        this.$http.post(setsUserAddRoleUrl).then(function (Response) {
          Materialize.toast(Response.body.meta.message, 2000, 'success');
        });
      }
  }
});
</script>
@endsection