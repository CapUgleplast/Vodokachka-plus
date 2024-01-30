<script setup lang="ts">
import {ref} from "vue";

const links = [
  {
    name: 'Тарифы и расходы',
    to: '/management'
  },
  {
    name: 'Клиенты',
    to: '/clients'
  },
  {
    name: 'Счета',
    to: '/bills'
  }
]

const toggle = ref(0)
</script>

<template>
  <div class="wrapper">
    <v-btn-toggle
      v-model="toggle"
      color="teal"
      variant=text
    >
        <v-btn v-for="item in links" :to="item.to">
          <div v-text="item.name"/>
        </v-btn>
    </v-btn-toggle>
  </div>
</template>

<style scoped>

</style>