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
            'dictionary': {
                'type': Object,
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
                'invitee': ''
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
            }
        }
    }
</script>
