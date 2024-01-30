<script lang="ts">
import {defineAsyncComponent, reactive, ref} from "vue";
export default {

  components: {
      modalTableEdit: defineAsyncComponent(()=> import('../../../modals/modalTableEdit.vue'))
  },

  props: {
    showHeaders: {
      type: Boolean,
      default: false
    },
    addItems:{
      type: Number,
      default: 0
    },
    editable: {
      type: Boolean,
      default: false
    },
    deletable: {
      type: Boolean,
      default: false
    },
    value: {
      type: Array<Object>,
      default: () => [
        {
          id: 1,
          month: 'Spinach',
          tariff: 23,
          expense: 0.4,
        },
        {
          id: 2,
          month: 'Spich',
          tariff: 53,
          expense: 0.4,
        },
      ]
    },
    headers: {
      type: Array<Object>,
      default: () => [
        {title: 'Месяц', key: 'month', editable: false},
        {title: 'Тариф', key: 'tariff', editable: true},
        {title: 'Расход', key: 'expense', editable: true},
      ],
    },
  },

  data:() => ({
    edit: {id: null, value: {}} as any,
    table: [] as any[]
  }),

  created() {
    this.table = this.valueFormatter(this.value)
  },

  methods: {
    valueFormatter(val: any[]): any[]{
        return val.map((item: any) => {
          return this.headers.reduce((acc: any, curr: any) => {
            if (curr.key in item) {
              acc[curr.key] = item[curr.key];
            }
            return acc;
          }, {});
        });
    },

    createItem(first: boolean){
        const template = {} as any
        this.headers.forEach((val: any)=>{ template[`${val.key}`] = ''})

        if(this.addItems > 0) {
          this.$emit('addTop')
        } else {
          this.$emit('addBottom')
        }

        const id = first ? -1 : this.table.length

        this.editItem(template, id)
    },

    editItem(item: any, id: number) {
        this.edit.value = item
        this.edit.id = this.value[id]?.id
    },

    deleteItem(id: number) {
        this.table.splice(id, 1)
        console.log(this.table, this.value)
        this.$emit('delete', this.value[id]?.id)
    },

    saveItem(item: any) {
        const replace = +!(this.edit.id == undefined)

        const id = replace ? this.value.findIndex((val: any)=> val.id == this.edit.id) : this.addItems >= 0 ? 0 : this.table.length

        console.log(id, replace, item, {...this.edit})
        this.table.splice(id, replace, item)

        if(!replace) {
          this.$emit('save', item)
        } else {
          this.$emit('edit', item, this.edit.id)
        }
        this.cancelEdit()
    },

    cancelEdit(){
        this.edit.id = null
        this.edit.value = {}
    }
  },

  watch:{
      value(val){
        this.table = this.valueFormatter(val)
      }
  },
}
</script>

<template>
    <div class="table">

      <div class="header"
           v-if="showHeaders"
      >
          <div class="cell"
               v-for="item in headers"
               v-text="item.title"
          />
          <div v-for="item in Array(+editable + +deletable)"/>
      </div>

      <v-btn v-if="addItems > 0"
             class="add-btn top"
             @click="createItem(true)"
      >
          <v-icon icon="mdi-plus-thick"/>
      </v-btn>


      <div class="body"
           v-for="(item, id) in table"
      >
          <div v-for="(value, idx) in Object.values(item)"
               class="cell"
               v-html="value"
          />
          <v-btn class="action-btn"
                 icon
                 v-if="editable"
                 @click="()=>editItem(item, id)"
          >
              <v-icon icon="mdi-pencil"/>
          </v-btn>
          <v-btn class="action-btn"
                 icon
                 v-if="deletable"
                 @click="()=>deleteItem(id)"
          >
              <v-icon icon="mdi-close-thick"
              />
          </v-btn>
      </div>


      <v-btn v-if="addItems < 0"
             class="add-btn bottom"
             @click="createItem(false)"
      >
        <v-icon icon="mdi-plus-thick"/>
      </v-btn>

      <modal-table-edit v-if="edit.id !== null && Object.values(edit.value)"
                        :value="edit.value"
                        :headers="headers"
                        @save="saveItem"
                        @cancel="cancelEdit"
      />
    </div>
</template>

<style lang="scss" scoped>



    .table {
      display: flex;
      flex-direction: column;

      .header{
        border-bottom: 1px solid #bbbbbb;
        height: 50px;

        .cell{
          font-size: 16px;
          font-weight: 500;
        }
      }

      .body{
        .action-btn{
          width: 36px;
          height: 36px;

          i{
            --v-icon-size-multiplier: 0.8;
            color: #484848;
          }
        }
      }


      & > * {
          display: flex;
          gap: 15px;
          align-items: center;
          padding: 8px 20px;
      }

      .add-btn{
        box-shadow: none;
        color: #046f74 !important;
        background-color: #B2DFDB;

        &.top {
          border-top-left-radius: 20px;
          border-top-right-radius: 20px;
        }

        &.bottom {
          border-bottom-left-radius: 20px;
          border-bottom-right-radius: 20px;
        }

      }

      .cell{
        width: 200px;
        align-self: center;
        text-align: center;
        overflow: hidden;
        max-height: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 15px;
        text-transform: capitalize;
      }
    }
</style>