<script setup lang="ts">

  import {onMounted, reactive, ref, watch} from "vue";
  import months from "@/common/months";

  const emit = defineEmits(['onChangeMonth', 'onChangeYear'])
  const props = defineProps(['fetchList', 'years', 'months'])

  const monthsList = reactive({value: months});

  const currentYearId = ref(0)

  watch(() => props.months, (value: string[])=>{
    monthsList.value = monthsList.value.map((val: any) => {
      return {
        title: val.title
      }
    })

    value?.forEach((val: string)=> {
      monthsList.value[Number.parseInt(val) - 1].available = true
    })
  }, {immediate: true})

  const changeYear = (up: boolean) => {

    up ? currentYearId.value++ : currentYearId.value--
    emit("onChangeYear", props.years[currentYearId.value])
  }

  const getNewMonth = (id: number) => {
    const getDate = new Date(props.years[currentYearId.value], id)
    emit("onChangeMonth", getDate)
  }

</script>

<template>
    <div class="calendar">
      <div class="header">
          <v-btn :disabled="!years[currentYearId-1]"
                 @click="changeYear(false)"
          >
            <v-icon icon="mdi-less-than"/>
          </v-btn>

          <span v-text="years[currentYearId]"/>

          <v-btn :disabled="!years[currentYearId+1]"
                 @click="changeYear(true)">
            <v-icon icon="mdi-greater-than"/>
          </v-btn>
      </div>

      <div class="body">
        <v-btn v-for="(item, id) in monthsList.value"
               v-text="item.title"
               :disabled="!item.available"
               @click="()=>getNewMonth(id)"
        />
      </div>
    </div>
</template>

<style lang="scss" scoped>
.calendar{
  .header{
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background-color: #d3d3d342;

    span{
      font-size: 18px;
      font-weight: 500;
    }

    button{
      background: transparent;
      height: 100%;
      box-shadow: none;
    }
  }

  .body{
    width: 100%;
    display: grid;
    justify-items: stretch;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    grid-template-rows: repeat(3, 1fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;

    button {
      height: 100px;
      background-color: #B2DFDB;
      border-radius: 0;
      color: #046f74;

      &:disabled{
        background-color: #d3d3d342;
        border: 1px solid #ededed;
        color: rgba(var(--v-theme-on-surface), 0.26);

      }
    }
  }
}
</style>