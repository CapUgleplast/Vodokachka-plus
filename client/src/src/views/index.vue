<script setup lang="ts">
import {defineAsyncComponent, onMounted} from "vue";

    const pages = {
        Desktop: defineAsyncComponent(()=>import('../components/pages/default/Desktop.vue'))
    }
</script>

<template>
  <div class="main">
      <component :is="pages.Desktop" />
  </div>
</template>

<style>
.main{
  display: flex;
  flex-direction: row;
  justify-content: center;
  margin: auto;
  max-width: 772px;
}
</style>
