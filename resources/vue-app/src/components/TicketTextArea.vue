<script>
export default {
  props: {
    type: String,
    label: String,
    name: String,
    value: String,
  },
  emits: ['textInput'],
}
</script>

<template>
  <div class="d-flex flex-column">
    <label class="mb-0 py-2">{{label}}</label>
    <div>{{value}}</div>
    <textarea v-on:input="$emit('textInput', {name, value: $event.target.value})" :type="type" :name="name" :value="value" class="form-control">
    </textarea>
  </div>
</template>