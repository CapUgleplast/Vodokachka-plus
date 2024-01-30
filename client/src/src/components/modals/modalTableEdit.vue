<script setup lang="ts">
import {computed, reactive, watch} from "vue";

  const props = defineProps(['value', 'headers'])
  const emit = defineEmits(['save', 'cancel'])
  const items = reactive(props.value)
  const headers = computed(()=> {
    return props.headers.reduce((acc: any, item: any) => {
      acc[item.key] = { ...item };
      return acc;
    }, {});
  })

  const save = () => emit("save", items)
  const cancel = () => emit("cancel")

</script>

<template>
  <teleport to="body">
    <div class="modal">
      <v-card >
        <v-card-title class="title">
          <span class="text-h5">asd</span>
        </v-card-title>

        <v-card-text>
          <v-container>
            <v-row>
              <v-col v-for="(item, id) in items"
                     cols="12"
                     sm="6"
                     md="4"
              >
                <v-text-field :disabled="!headers[id].editable"
                              :type="headers[id].type || 'text'"
                              v-model="items[id]"
                              :label="headers[id].title"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-card-text>

        <v-card-actions>
          <v-spacer></v-spacer>
          <v-btn
              color="blue-darken-1"
              variant="text"
              @click="cancel"
          >
            Отменить
          </v-btn>
          <v-btn
              color="blue-darken-1"
              variant="text"
              @click="save"
          >
            Сохранить
          </v-btn>
        </v-card-actions>
      </v-card>
    </div>
  </teleport>
</template>

<style scoped>
.modal{
  position: fixed;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  display: flex;
  align-items: center;
  justify-content: center;
  background: #00000042;

  .v-card{
    width: 50%;
    height: 30%;
    display: flex;
    flex-direction: column;

    .title{
        padding: 24px 34px 10px;
    }
  }
}
</style>