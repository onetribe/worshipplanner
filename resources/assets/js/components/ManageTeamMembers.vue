<template>
<div v-cloak>
<div class="card-panel" >
  <div class="card-content" style="overflow:auto;">
    <table class="striped">
        <thead>
            <tr>
                <th>{{ dictionary.name }}</th>
                <th>{{ dictionary.role }}</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tr v-for="membership in teamMembers">
            <td>{{ membership.user.data.first_name }} {{ membership.user.data.last_name }}</td>
            <td>{{ membership.role }}</td>
            <td>
                <a 
                    class="cursorPointer" 
                    v-if="membership.role == 'Administrator' && userId != membership.user.data.id" 
                    v-on:click="changeRole(membership.user_id, 'User')"
                >{{ dictionary.remove_admin }}</a>
                <a 
                    class="cursorPointer" 
                    v-else-if="membership.role == 'User'" 
                    v-on:click="changeRole(membership.user_id, 'Administrator')"
                >{{ dictionary.make_admin }}</a>
            </td>
            <td><a class="cursorPointer" v-on:click="removeMember(membership.user_id)">{{ dictionary.remove }}</a></td>
        </tr>
    </table>
  </div>
</div>

<div class="card-panel">
  <div class="card-content" >
    <h2>{{ dictionary.invite_member }}</h2>
    <div class="input-field col s12" >
      <input type="email" id="invitee" v-model="invitee"/>
      <label for="invitee">{{ dictionary.email }}</label>
    </div>
    <button class="waves-effect waves-light btn">{{ dictionary.invite }}</button>
  </div>
</div>

<div class="card-panel">
  <div class="card-content" >
    <h2>{{ dictionary.create_team }}</h2>
    <p>
        {{ dictionary.create_team_explanation }}
    </p>
    <div class="row">
      <div class="input-field col s6">
        <input id="team_title" type="text" class="form-control" name="team_title" v-model="newTeamTitle">
        <label for="team_title">{{ dictionary.team_name }}</label>
      </div>
    </div>
    <label >{{ dictionary.country }}</label>
    <div class="row">

      <div class="input-field col s3">
        <select id="country_code" class="browser-default" v-model="selectedCountry" >
            <option v-for="country_code in countryCodes" :value="country_code.code">{{ country_code.name }}</option>>
        </select>
      </div>
    </div>
    <div class="row">
        <button class="waves-effect waves-light btn" v-on:click="createTeam">{{ dictionary.create_team }}</button>
    </div>
  </div>
</div>

</div>
</template>

<script>


    export default {
        props: {
            'indexUrl': {
              'type': String,
              'required': true
            },
            'changeRoleUrl': {
              'type': String,
              'required': true
            },
            'removeUrl': {
              'type': String,
              'required': true
            },
            'teamStoreUrl': {
              'type': String,
              'required': true
            },
            'dictionary': {
                'type': Object,
                'required': true
            },
            'countryCodes': {
                'type': Array,
                'required': true
            },
            'userId': {
                'type': Number,
                'required': true
            }
        },
        data() {
            return {
                'teamMembers': [],
                'invitee': '',
                'newTeamTitle': '',
                'selectedCountry': ''
            }
        },
        computed: {
            'members': function () {
                var members = [];
                for (var i = 0; i < this.teamMembers.length; i++) {
                    members.push(this.teamMembers[i].user.data);
                }
                return members;
            }
        },
        mounted() {
            this.fetchMembers();
        },
        methods: {
            fetchMembers: function () {
                this.$http.get(this.indexUrl).then(function (Response) {
                    this.teamMembers = Response.body.data;
                }.bind(this));
            },
            removeMember: function (userId) {
                if (! window.confirm(this.dictionary.confirm_delete)) {
                    return;
                }
                
                this.$http.delete(this.removeUrl + "/" + userId).then(function (Response) {
                    this.fetchMembers();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                }.bind(this));
            },
            changeRole: function (userId, role) {
                this.$http.put(this.changeRoleUrl + "/" + userId, {
                    'role': role
                }).then(function (Response) {
                    this.fetchMembers();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                }.bind(this));
            },
            createTeam: function () {
                var data = {'title': this.newTeamTitle, 'country_code': this.selectedCountry};
                this.$http.post(this.teamStoreUrl, data).then(function (Response) {
                    
                    Materialize.toast(Response.body.meta.message, 3500, 'success');
                }.bind(this));
            }
        }
    }
</script>
