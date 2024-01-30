<script setup lang="ts">
  import {defineAsyncComponent, onMounted} from "vue";
  import axios from "@/apiConfig";
  import {reactive} from "vue";

  const pages = {
    Desktop: defineAsyncComponent(()=>import('../../components/pages/bills/Desktop.vue'))
  }
  const bearer = {
    headers: {
      Authorization: `Bearer ${localStorage.getItem('login')}`
    },
  }

  const state = reactive({
    fetchList: [] as any[],
    fetchAvailable: {} as any
  });

  onMounted( async () => await axios.get('api/bills', bearer)
      .then((val: any)=> {
        state.fetchAvailable = val?.data
      })
  )

  const getBills = async (date: Date | string) => {
    date.setMonth(date.getMonth()+1)
    date =  new Date(date).toISOString().replace('T', ' ').slice(0, 19)
    await axios.post(`api/bills/monthly`,
        {
          date_point: date
        },
        bearer)
        .then((val: any)=> {
            state.fetchList = val.data
        })
  }
</script>

<template>
  <div class="main">
    <component v-if="state.fetchAvailable"
               :is="pages.Desktop"
                @setMonth="getBills"
               :fetchList="state.fetchList"
               :available="state.fetchAvailable"
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
