<script>
export default {
  data() {
    return {
      selected: '',
      options: [
        { text: 'Selecione', value: '' }
      ]
    }
  }
}
</script>

<template>
  <select v-model="selected">
    <option v-for="(option, index) in options" :value="option.value" v-bind:key="index" >
      {{ option.text }}
    </option>
  </select>
  
</template>