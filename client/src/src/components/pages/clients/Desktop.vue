<script setup lang="ts">

  import ManagementTable from "@/components/pages/management/blocks/managementTable.vue";
  import axios from "@/apiConfig";
  import {computed, onMounted, watch} from "vue";

  const props = defineProps(['fetchList', 'loading'])
  const emit = defineEmits(['delete', 'save', 'edit'])


  const headers = [
    {title: 'ФИО', key: 'fio', editable: true},
    {title: 'Площадь участка (М^2)', key: 'area', editable: true, type: 'number'},
    {title: 'Дата подключения', key: 'start_date', editable: true, type: 'date'},
  ]

  const dateParser = computed(()=> {
    return props.fetchList.map((val: any) => {
      return {
        ...val,
        start_date: new Date(val.start_date).toISOString().slice(0, 10)
      }
    })
  })

  watch(() => props.fetchList, () => {
    dateParser.value;
  });

  const saveClient = async (val: any, id?: number) => {
      if(Number.isFinite(id)) {
        emit('edit', val, id)
      } else {
        emit('save', val)
      }

  }
  const deleteClient = async (id: number) => {
      emit('delete', id)
  }
</script>

<template>
    <div class="wrapper">
        <div v-if="loading" class="load">
          <div  class="preload-anim"/>
        </div>
        <management-table v-else
                          :add-items="-1"
                          editable
                          deletable
                          show-headers
                          @save="saveClient"
                          @edit="saveClient"
                          @delete="deleteClient"
                          :headers="headers"
                          :value="dateParser"
        />
    </div>
</template>

<style lang="scss" scoped>
.wrapper{
  width: 100%;

  .load{
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 300px;
  }
}
</style>