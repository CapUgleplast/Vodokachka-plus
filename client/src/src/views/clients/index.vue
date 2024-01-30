<script setup lang="ts">
import {defineAsyncComponent, onMounted, reactive, ref} from "vue";
import axios from "@/apiConfig";

  const pages = {
    Desktop: defineAsyncComponent(()=>import('../../components/pages/clients/Desktop.vue'))
  }
  const loading = ref(false);
  const state = reactive({
    fetchList: [],
  });

  const bearer = {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('login')}`
    },
  }

  onMounted( async () => {
        loading.value = true
        await axios.get('api/residents', bearer)
            .then((val: any) => {
              state.fetchList = val?.data
            })
            .finally(()=>{
              loading.value = false
            })
      }
  )

  const saveClient = async (val: any, id?: number) => {
    val.start_date =  new Date(val.start_date.split('.').reverse()).toISOString().replace('T', ' ').slice(0, 19)

    if(Number.isFinite(id)) {
      await axios.put(`api/residents/${id}`, val, bearer)
    } else {
      await axios.post('api/residents', val, bearer)
    }
  }

  const deleteClient = async (id: number) => {
    await axios.delete(`api/residents/${id}`, bearer)
        .then((val: any)=> {
          state.fetchList = val?.data
        })
  }
</script>

<template>
  <div class="main">
      <component :is="pages.Desktop"
                 :fetchList="state.fetchList"
                 :loading="loading"
                 @save="saveClient"
                 @edit="saveClient"
                 @delete="deleteClient"
      />
  </div>
</template>

<style>
.main{
  margin-top: 60px !important;
  display: flex;
  flex-direction: row;
  justify-content: center;
  margin: auto;
  max-width: 772px;
}
</style>
