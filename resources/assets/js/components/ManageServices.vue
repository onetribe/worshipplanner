<template>
<div class="row" v-cloak>

<div class="col m4 s12">
    <div class="card-panel">
      <div class="card-content" >
        <h2>{{ dictionary.create_new }}</h2>
        <div class="input-field col s12" >
          <input type="text" id="newService" v-model="newServiceTitle"/>
          <label for="newService">{{ dictionary.title }}</label>
        </div>
        <button class="waves-effect waves-light btn" v-on:click="add()">{{ dictionary.save }}</button>
      </div>
    </div>
</div>


<div class="col m8 s12">
    <div class="card-panel" >
      <div class="card-content" style="overflow:auto;">
        <table class="striped">
            <tr v-for="service in services">
                <td>
                    {{ service.title }}
                </td>
                <td width="80">
                    <a class="waves-effect waves-light btn-flat" 
                       v-on:click="remove(service.id)"
                    ><i class="material-icons">delete</i></a>
                </td>
            </tr>
        </table>
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
            'dictionary': {
                'type': Object,
                'required': true
            }
        },
        data() {
            return {
                'services': [],
                'newServiceTitle': ""
            }
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch: function () {
                this.$http.get(this.indexUrl).then(function (Response) {
                    this.services = Response.body.data;
                }.bind(this));
            },
            remove: function (serviceId) {
                this.$http.delete(this.removeUrl + "/" + serviceId).then(function (Response) {
                    this.fetch();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                }.bind(this));
            },
            add: function () {
                if (this.newServiceTitle.trim() == "") {
                    Materialize.toast(this.dictionary.please_add_title, 2000, 'failure');
                    return;
                }

                this.$http.post(this.addUrl, {
                    'title': this.newServiceTitle.trim()
                }).then(function (Response) {
                    this.fetch();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                    this.newServiceTitle = "";
                }.bind(this));
            }
        }
    }
</script>
