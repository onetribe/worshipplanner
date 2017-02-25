<template>
<div class="row" v-cloak>

<div class="col m4 s12">
    <div class="card-panel">
      <div class="card-content" >
        <ul class="collection">
          <li class="collection-item" v-for="band in bands">
            <div class="">
              <a v-on:click="selected = band.id" href="#">{{ band.title }}</a>
                <a href="#"
                    class="waves-effect waves-light btn-flat tooltipped secondary-content" 
                    v-on:click="remove(band.id)"
                    ><i class="material-icons">delete</i></a>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="card-panel">
      <div class="card-content" >
        <h4>{{ dictionary.create_new }}</h4>
        <div class="input-field col s12" >
          <input type="text" id="newService" v-model="newTitle"/>
          <label for="newService">{{ dictionary.title }}</label>
        </div>
        <button class="waves-effect waves-light btn" v-on:click="add()">{{ dictionary.save }}</button>
      </div>
    </div>
</div>


<div class="col m8 s12">
  <div class="card-panel" >
    <div class="card-content" style="overflow:auto;" v-if="selectedBand">
      <h3>{{ selectedBand.title }}</h3>

      <table class="striped" v-if="selectedBand">
        <thead>
          <tr>
            <th>{{ dictionary.member }}</th>
            <th>{{ dictionary.normally_plays }}</th>
            <th></th>
            <th></th>
          </tr>
        </thead>
        <tr v-for="bandSubscription in selectedBand.bandSubscriptions.data">
            <td>
                {{ bandSubscription.user.data.name }}
            </td>
            <td>
              <div class="chip" v-for="bandRole in bandSubscription.bandRoles.data">
                {{ bandRole.title }}
                <i class="close material-icons" v-on:click="removeRole(bandSubscription.user.data.id, bandRole.id)">close</i>
              </div>

            </td>
            <td>
              <select class="browser-default" 
                      v-on:change="addRole(bandSubscription.user.data.id, $event)"
              >
                  <option>{{ dictionary.add_role }}</option>
                  <option v-for="role in band_roles" :value="role.id">{{ role.title }}</option>
              </select>
            </td>
            <td width="80">

                <a class="waves-effect waves-light btn-flat" 
                   v-on:click="removeUser(bandSubscription.user.data.id)"
                ><i class="material-icons">delete</i></a>
            </td>
        </tr>
      </table>

      <hr/>
      <div class="input-field col s12 m6">
        <select id="userSelect" class="browser-default" v-on:change="addUser">
          <option value="" disabled selected>{{ dictionary.add_member }}</option>
          <option :value="user.id" v-for="user in users">{{ user.name }}</option>
        </select>
      </div>
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
            'removeUrl': {
              'type': String,
              'required': true
            },
            'addUrl': {
              'type': String,
              'required': true
            },
            'bandRolesIndexUrl': {
              'type': String,
              'required': true
            },
            'addUserToBandUrl': {
              'type': String,
              'required': true
            },
            'removeUserFromBandUrl': {
              'type': String,
              'required': true
            },
            'addUserRoleToBandUrl': {
              'type': String,
              'required': true
            },
            'removeUserRoleFromBandUrl': {
              'type': String,
              'required': true
            },
            'usersIndexUrl': {
              'type': String,
              'required': true
            },
            'dictionary': {
                'type': Object,
                'required': true
            }
        },
        data() {
            return {
                'bands': [],
                'band_roles': [],
                'users': [],
                'newTitle': "",
                'selected': ""
            }
        },
        computed: {
            'selectedBand': function () {
                if (this.bands.length == 0) {
                    return;
                }

                if (this.selected == "") {
                    return this.bands[0];
                }

                for (var i = 0; i < this.bands.length; i++) {
                    if (this.bands[i].id == this.selected) {
                        return this.bands[i];
                    }
                }
            }
        },
        mounted() {
            this.fetch();
            this.fetchBandRoles();
            this.fetchUsers();
        },
        methods: {
            fetch() {
                this.$http.get(this.indexUrl).then(function (Response) {
                    this.bands = Response.body.data;
                }.bind(this));
            },
            fetchBandRoles() {
                this.$http.get(this.bandRolesIndexUrl).then(function (Response) {
                    this.band_roles = Response.body.data;
                }.bind(this));
            },
            fetchUsers() {
                this.$http.get(this.usersIndexUrl).then(function (Response) {
                    this.users = Response.body.data;
                }.bind(this));
            },
            remove(bandId) {
                if (! window.confirm(this.dictionary.confirm_delete)) {
                    return;
                }

                this.$http.delete(this.removeUrl + "/" + bandId).then(function (Response) {
                    this.fetch();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                    if (bandId == this.selected) {
                      this.selected = this.bands[0] ? this.bands[0].id : null;  
                    }
                }.bind(this));
            },
            add() {
                if (this.newTitle.trim() == "") {
                    Materialize.toast(this.dictionary.please_add_title, 2000, 'failure');
                    return;
                }

                this.$http.post(this.addUrl, {
                    'title': this.newTitle.trim()
                }).then(function (Response) {
                    this.fetch();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                    this.newTitle = "";
                }.bind(this));
            },
            addUser(e) {
              
              var userId = e.target.value;
              var addUserToBandUrl = this.addUserToBandUrl.replace("bandId", this.selectedBand.id).replace("userId", userId);
              
              this.$http.post(addUserToBandUrl).then(function (Response) {
                this.fetch();
                Materialize.toast(Response.body.meta.message, 2000, 'success');
              }.bind(this));
            },
            removeUser(userId) {
              if (! window.confirm(this.dictionary.confirm_delete)) {
                return;
              }
              var removeUserFromBandUrl = this.removeUserFromBandUrl.replace("bandId", this.selectedBand.id).replace("userId", userId);
              
              this.$http.delete(removeUserFromBandUrl).then(function (Response) {
                this.fetch();
                Materialize.toast(Response.body.meta.message, 2000, 'success');
              }.bind(this));
            },
            addRole(userId, e) {
              //console.log(e.target.data.userid);
              
              var bandRoleId = e.target.value;
              var addUserRoleToBandUrl = this.addUserRoleToBandUrl
                  .replace("bandId", this.selectedBand.id)
                  .replace("userId", userId)
                  .replace("bandRoleId", bandRoleId);
              
              this.$http.post(addUserRoleToBandUrl).then(function (Response) {
                this.fetch();
                Materialize.toast(Response.body.meta.message, 2000, 'success');
              }.bind(this));
            },
            removeRole(userId, bandRoleId) {
              var removeUserRoleFromBandUrl = this.removeUserRoleFromBandUrl
                  .replace("bandId", this.selectedBand.id)
                  .replace("userId", userId)
                  .replace("bandRoleId", bandRoleId);
              
              this.$http.delete(removeUserRoleFromBandUrl).then(function (Response) {
                this.fetch();
                Materialize.toast(Response.body.meta.message, 2000, 'success');
              }.bind(this));
            }
        }
    }
</script>
