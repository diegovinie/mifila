<template lang="html">
  <div :class="['form-group', errors[name] ? 'has-error' : '']">
    <label for="email">{{ label }}</label>
    <input
      :type="type"
      class="form-control"
      :name="name"
      :id="name"
      v-model="data"
      :readonly="!editable"/>
    <span v-if="errors[name]" :class="['label label-danger']">
      {{ errors[name][0] }}
    </span>
  </div>
</template>

<script>
export default {
  computed: {
    data: {
      get: function () {
        return this.value
      },
      set: function (val) {
        this.$emit('typing', this.name, val)
      }
    }
  },

  props: ['errors', 'value', 'name', 'label', 'type', 'editable']
}
</script>

<style lang="css">
</style>
