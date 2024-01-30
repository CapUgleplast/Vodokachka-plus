<script setup lang="ts">

  import ManagementTable from "@/components/pages/management/blocks/managementTable.vue";
  import {computed, reactive, ref, watch} from "vue";
  import months from "@/common/months";
  import axios from "axios";

  const props = defineProps(['fetchPlanned', 'fetchCurrent', "fetchPast", 'loading'])
  const emit = defineEmits(['delete', 'save', 'edit', 'add'])

  const headersPast = [
    {title: 'Месяц', key: 'string_date', editable: false},
    {title: 'Тариф', key: 'tariff', editable: true, type: 'number'},
    {title: 'Расход', key: 'expense', editable: true, type: 'number'},
  ]

  const headersPlanned = [
    {title: 'Месяц', key: 'string_date', editable: false},
    {title: 'Тариф', key: 'tariff', editable: true, type: 'number'},
    {title: 'Расход', key: 'expense', editable: false, type: 'number'},
  ]

  const planned = ref(null)

  const showPlanned = ref(false)


  const saveManagement = async (val: any, id?: number) => {
    if(Number.isFinite(id)) {
      emit('edit', val, id)
    } else {
      emit('save', val)
    }
  }

  setTimeout(()=>{
    console.log(props)
  }, 1000)

</script>

<template>
    <div class="wrapper">
        <management-table class="table cap"
                          :class="{'no-border': showPlanned}"
                          show-headers
                          :headers="headersPast"
                          :value="[]"

        />
        <div v-if="!loading">
            <div class="planned">
                <v-btn @click="showPlanned = !showPlanned"
                       :class="{'--active': showPlanned}"
                       icon
                >
                  <v-icon icon="mdi-calendar-month"
                          size="large"
                  />
                </v-btn>
                <management-table v-if="showPlanned"
                                  class="table"
                                  editable
                                  deletable
                                  :add-items="1"
                                  ref="planned"
                                  :headers="headersPlanned"
                                  :value="props.fetchPlanned"
                                  @edit="saveManagement"
                                  @delete="(id: number) => emit('delete', id)"
                                  @save="saveManagement"
                />
            </div>
            <management-table class="table current"
                              editable
                              :headers="headersPast"
                              :value="props.fetchCurrent"
                              @edit="saveManagement"

            />
            <management-table class="table past"
                              :headers="headersPast"
                              :value="props.fetchPast"

            />
        </div>
        <div v-else class="load">
          <div  class="preload-anim"/>
        </div>
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

  .planned{
    button{
      position: absolute;
      margin-left: -60px;
      margin-top: -50px;

      &.--active{
        background-color: #0ca7a6;
        color: white;
      }
    }

    .table{
      :deep(.body){
        background-color: #b2dfdb42;
      }
    }
  }

  .table{
    &.past{
      :deep(.body){
        background-color: #d3d3d342;
      }
    }

  }

  .cap{
    &.no-border {
      :deep(.header){
        border: none;
      }
    }
  }
}

</style>