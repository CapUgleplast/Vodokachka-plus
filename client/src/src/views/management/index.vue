<script setup lang="ts">
  import {defineAsyncComponent, onMounted, reactive, ref} from "vue";
  import axios from "@/apiConfig";
  import months from "@/common/months";

  const pages = {
    Desktop: defineAsyncComponent(()=>import('../../components/pages/management/Desktop.vue'))
  }

  const loading = ref(false)

  const state = reactive({
    fetchPlanned: [] as any[],
    fetchCurrent: [] as any[],
    fetchPast: [] as any[],
  });

  const bearer = {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('login')}`
    },
  }
  const getPlanned = axios.get(`api/management/planned`, bearer)
  const getCurrent = axios.get(`api/management/current`, bearer)

  const getPast = axios.get(`api/management/previous`, bearer)

  const lastPlanned = ref(new Date()) as any

  onMounted( async () => {
        loading.value = true
        await Promise.allSettled([getPlanned, getCurrent, getPast])
            .then(value => {
              state.fetchPlanned = value[0]?.value?.data.reverse()
              state.fetchCurrent = value[1]?.value?.data
              state.fetchPast = value[2]?.value?.data

              if (state.fetchPlanned.length) {
                lastPlanned.value = new Date(state.fetchPlanned[0].begin_date)
              } else {
                lastPlanned.value = new Date(state.fetchCurrent[0].begin_date)
              }
              lastPlanned.value.setDate(15);
            })
            .finally(()=>{
              loading.value = false
            })
      }

  )

  const editPeriod = async (val: any, id: number) => {
      await axios.put(`api/management/${id}`, val, bearer)
  }

  const addPeriod = async (item: any) => {

    lastPlanned.value.setMonth(lastPlanned.value.getMonth() + 1);
    const lastPlannedString = new Date(lastPlanned.value).toISOString().replace('T', ' ').slice(0, 19)

    await axios.post(`api/periods`, {date_point: lastPlannedString}, bearer)
        .then((val: any)=> {
          const newItem = {...item, ...val.data, period_id: val.data.id}
          state.fetchPlanned = [newItem, ...state.fetchPlanned]
          editPeriod(newItem, val.data.id)
        })
  }

  const deletePeriod = async (id: number) => {
    await axios.delete(`api/management/${id}`, bearer)
        .then((val: any)=> {
            state.fetchPlanned.splice(state.fetchPlanned.findIndex((val: any) => val.id == id), 1)
        })
  }
</script>

<template>
  <div class="main">
    <component :is="pages.Desktop"
               :fetchCurrent="state.fetchCurrent"
               :fetchPlanned="state.fetchPlanned"
               :fetchPast="state.fetchPast"
               :loading="loading"
               @save="addPeriod"
               @edit="editPeriod"
               @delete="deletePeriod"

    />
  </div>
</template>

<style>
.main{
  display: flex;
  flex-direction: row;
  justify-content: center;
  margin: auto;
  width: 772px;
  margin-top: 60px !important;
}
</style>
