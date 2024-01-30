<script setup lang="ts">
import {onMounted, reactive, ref, watch} from "vue";
  import axios from "@/apiConfig";
import router from "@/router";

  const formData = reactive({
    login: '',
    password: ''
  })

  const authErr = ref('');

  onMounted(()=>{
    localStorage.removeItem('login')
  })

  const loginRules = [
    (val: string) => {
      if (val?.length > 3) return true

      return 'Логин должен содержать минимум 3 символа'
    },
    (val: string) => {
      if (!authErr.value && val.length || localStorage.getItem('login')) return true

      return 'Проверьте верность введенных данных'
    },
  ]

  const passwordRules = [
    (val: string) => {
      if (val?.length > 3) return true

      return 'Пароль должен содержать минимум 3 символа'
    }
  ]

  const authRules = () => {
        if (!authErr.value && formData.login.length && formData.password.length || localStorage.getItem('login')) authErr.value = ''

        authErr.value = 'Проверьте верность введенных данных'
  }

  const authenticate = async () => {
    await axios.post('api/login', formData)
        .then((val: any)=> {
          localStorage.setItem('login', val.data?.token);
          router.push('/')
        })
        .catch((err: any)=> {
            authRules()
            console.log(authErr.value)
        })
  }
</script>

<template>
  <div class="wrapper">
    <v-form class="form" @submit.prevent="authenticate">
      <h1 v-text="'Авторизация'"/>
      <v-text-field
          v-model="formData.login"
          label="Логин"
          :rules="loginRules"
          @input="authErr = ''"
      />

      <v-text-field
          v-model="formData.password"
          label="Пароль"
          :rules="passwordRules"
          @input="authErr = ''"
      />
      <v-btn type="submit" block class="mt-2">Войти</v-btn>
      <v-alert v-if="authErr"
               class="error"
               v-html="authErr"
               color="red"
      />
    </v-form>
  </div>
</template>

<style lang="scss" scoped>
  .wrapper{
    width: 100%;
    display: flex;
    justify-content: center;

    .form{
      max-width: 500px;
      width: 100%;
      padding: 50px;
      display: flex;
      flex-direction: column;
      background: white;
      box-shadow: 3px 9px 20px 0px rgba(34, 60, 80, 0.2);
      border-radius: 15px;
      gap: 20px;

      h1{
        align-self: center;
      }

      .error{
        align-content: center;
        justify-content: center;
        position: absolute;
        margin-left: 40px;
        margin-top: 420px;
      }
    }
  }
</style>