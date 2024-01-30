<script setup lang="ts">
import { useRoute } from "vue-router";
import NavBar from "@/components/layouts/navBar.vue";
const route = useRoute();
</script>

<template>
  <div class="layout">
    <header>
      <h1 class="logo"
          v-text="'Водокачка +'"
      />

    </header>
    <slot />

  </div>
</template>

<style lang="scss" scoped>
  .layout{
    padding-bottom: 120px;
    background: whitesmoke;
    height: 100vh;

    .background{
      column-count: 3; /* Установка количества колонок */
      column-gap: 20px;
    }
  }
  header{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    padding: 150px 100px 0;
    gap: 160px;

    h1{
      color: #009b94;
      font-size: 40px;
    }
  }
</style>
