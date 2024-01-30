<script setup lang="ts">

  import calendar from "@/components/pages/bills/blocks/monthCalendar.vue"
  import months from "@/common/months";
  import {computed, nextTick, ref, watch} from "vue";
  const emit = defineEmits(['setMonth'])
  const props = defineProps(['fetchList', 'available'])

  const headers = [
    {
      title: '№',
      align: 'start',
      sortable: false,
      key: 'id',
    },
    {
      title: 'ФИО',
      sortable: true,
      key: 'fio',
    },
    {
      title: 'Сумма (руб.)',
      sortable: true,
      key: 'amount_rub',
    },
  ] as any[]


  const years = computed(()=> {
    return Object.keys(props.available)
  })

  watch(()=>props.available, ()=>{
    years.value
    changeYear(years.value[0])
  })

  watch(()=>props.fetchList, ()=>{
    nextTick(()=>{
      window.scrollTo({top: 500, behavior: "smooth"})
    })
  })

  const currentYear = ref(0)
  const currentMonth = ref('')

  const changeYear = (val: string) => {
    currentYear.value = Number.parseInt(val)
  }

  const changeMonth = (val: Date) => {
    currentMonth.value = months[val.getMonth()].title
    emit('setMonth', val)
  }

</script>

<template>
    <div class="wrapper">
        <calendar class="calendar"
                  @on-change-month="changeMonth"
                  @on-change-year="changeYear"
                  :years="years"
                  :months="props.available[currentYear]"
        />
        <div v-if="currentMonth"
             class="body">
            <div class="title">{{ `${currentMonth} ${currentYear}` }}</div>
            <v-data-table class="table"
                          :headers="headers"
                          :items="props.fetchList"

            />
        </div>
    </div>
</template>

<style lang="scss" scoped>
.wrapper{
  width: 100%;

  .body{
    margin-top: 60px;

      .title {
        height: 50px;
        display: flex;
        align-items: center;
        padding: 16px;
        font-size: 20px;
        font-weight: 500;
        justify-content: center;
      }
  }

}
</style>