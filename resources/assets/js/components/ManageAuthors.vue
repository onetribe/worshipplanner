<template>
<div class="row" v-cloak>

<div class="col m4 s12">
    <div class="card-panel">
      <div class="card-content" >
        <h2>{{ dictionary.create_new }}</h2>
        <div class="input-field col s12" >
          <input type="text" id="first_name" v-model="newAuthor.first_name"/>
          <label for="first_name">{{ dictionary.first_name }}</label>
        </div>
        <div class="input-field col s12" >
          <input type="text" id="middle_name" v-model="newAuthor.middle_name"/>
          <label for="middle_name">{{ dictionary.middle_name }}</label>
        </div>
        <div class="input-field col s12" >
          <input type="text" id="last_name" v-model="newAuthor.last_name"/>
          <label for="last_name">{{ dictionary.last_name }}</label>
        </div>
        <button class="waves-effect waves-light btn" v-on:click="add()">{{ dictionary.save }}</button>
      </div>
    </div>
</div>

<div class="col m8 s12">
    <div class="card-panel" >
      <div class="card-content" style="overflow:auto;">
        <div class="input-field col s6">
          <input id="search" type="search" class="" v-model="searchText"/>
          <label for="search"><i class="material-icons prefix">search</i></label>
        </div>
        <table class="striped">
            <tr v-for="author in authorsFiltered">
                <td>
                    {{ author.name }}
                </td>
                <td>
                    <a v-if="!author.is_default" 
                       class="waves-effect waves-light btn-flat" 
                       v-on:click="remove(author.id)"
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
var blankAuthor = {
    'first_name': "",
    'middle_name': "",
    'last_name': ""
};

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
                'authors': [],
                'newAuthor': blankAuthor,
                'searchText': ""
            }
        },
        computed: {
            authorsFiltered: function () {
                return this.authors.filter(function (author) {
                  var searchStr = new RegExp(this.searchText.replace(" ", ".*"), "i");

                  var authorSearch = author.name.search(searchStr);
                  
                  return authorSearch >= 0 ? true : false;
                }, this);
            }
        },
        mounted() {
            this.fetch();
        },
        methods: {
            fetch: function () {
                this.$http.get(this.indexUrl).then(function (Response) {
                    this.authors = Response.body.data;
                }.bind(this));
            },
            remove: function (authorId) {
                if (! window.confirm(this.dictionary.confirm_delete)) {
                  return;
                }
                this.$http.delete(this.removeUrl + "/" + authorId).then(function (Response) {
                    this.fetch();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                }.bind(this));
            },
            add: function () {
                if (this.newAuthor.first_name.trim() == "") {
                    Materialize.toast(this.dictionary.please_add_first_name, 2000, 'failure');
                    return;
                }

                this.$http.post(this.addUrl, this.newAuthor).then(function (Response) {
                    this.fetch();
                    Materialize.toast(Response.body.meta.message, 2000, 'success');
                    this.newAuthor = blankAuthor;
                }.bind(this));
            }
        }
    }
</script>
