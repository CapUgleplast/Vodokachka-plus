<script setup lang="ts">
    const links = [
      {
        name: 'Тарифы и расходы',
        desc: 'Управляйте расходами и планируйте тарифы наперед',
        to: '/management'
      },
      {
        name: 'Клиенты',
        desc: 'Расширяйте список ваших клиентов',
        to: '/clients'
      },
      {
        name: 'Счета',
        desc: 'Вся история выставленных счетов в одном месте',
        to: '/bills'
      }
    ]
</script>

<template>
  <div class="wrapper">
      <router-link v-for="(item, id) in links"
                   :to="item.to"
                   :class="`card_${id+1}`"
      >
        <div class="title"
             v-text="item.name"/>
        <div class="description"
             v-text="item.desc"/>
      </router-link>
  </div>
</template>

<style lang="scss" scoped>
  .wrapper{
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    grid-template-rows: repeat(5, 1fr);
    grid-column-gap: 0px;
    grid-row-gap: 0px;
    justify-items: center;
    height: 420px;
    width: 700px;
    align-items: center;
    gap: 15px;

    & > * {
      height: 100%;
      width: 100%;
      padding: 12px 24px;
      justify-content: space-between;
      display: flex;
      flex-direction: column;
      background-color: #b2dfdb80;
      color: #004652;
      border-radius: 10px;

      .title{
        font-size: 45px;
      }

      .description{
        font-size: 18px;
        font-weight: 300;
      }

      &:hover{
        background-color: #8fcdc7 !important;
      }
    }

    .card_1{
      grid-area: 1 / 1 / 6 / 3;
    }

    .card_2{
      grid-area: 1 / 3 / 4 / 5;
    }

    .card_3{
      grid-area: 4 / 3 / 6 / 5;
    }
  }
</style>