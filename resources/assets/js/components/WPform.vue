<template>
<form class="form">
  <h3 v-show="title">{{ title }}</h3>
  <slot name="errors">
      <div class="card-panel red lighten-2" v-if="errors.length > 0">
        <ul>
            <li v-for="error in errors">
                <ul>
                    <li v-for="message in error">{{ message }}</li>
                </ul>
            </li>
        </ul>
      </div>
  </slot>
  <div class="card-panel light-green lighten-4" v-if="successmessage">
    {{ successmessage }}
  </div>
  <slot name="help"></slot>
  <slot name="elements"></slot>
  <slot name="buttons">
      <a class="waves-effect btn cursorPointer" v-on:click="submitted()">{{ buttontext }}</a>
  </slot>
</form>
</template>

<script>
    export default {
        props: {
            'title': {
              'type': String,
              'default': ""
            },
            'buttontext': {
              'type': String,
              'default': ""
            },
            'successmessage': {
              'type': String,
              'default': ""
            },
            'errors': {
              'type': Array,
              'default': []
            },
            'submitted': {
              'type': Function,
              'required': true
            }
        }
    }
</script>
