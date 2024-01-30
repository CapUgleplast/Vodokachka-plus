<script setup lang="ts">
import { useRoute } from "vue-router";
import NavBar from "@/components/layouts/navBar.vue";
import {computed} from "vue";
import Layout from "@/layouts/auth/layout.vue";

</script>

<template>
  <div class="layout">
    <header :class="{'shadow': $route.meta.navBar}"
      >
      <h1 class="logo"
          v-text="'Водокачка +'"
          @click="$router.push({name: 'home'})"
      />
      <nav-bar v-if="$route.meta.navBar"
                class="nav-bar"/>

    </header>
    <slot />
  </div>
</template>

<style lang="scss" scoped>
  .layout{
    padding-bottom: 120px;
  }

  header{
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: space-between;
    padding: 150px 100px 0px;

    &.shadow {
      box-shadow: 4px 4px 65px -6px rgba(34, 60, 80, 0.10);
    }

    h1{
      margin-bottom: 120px;
      cursor: pointer;
      color: #009b94;
      font-size: 40px;
    }
  }

</style>
