<template>
  <v-snackbar
    v-model="show_snackbar"
    app
    top
    right
    text
    :timeout="toast.timeout"
    :color="toast.color"
    data-cy="snackbar"
  >
    {{ toast.message }}
    <template #action="{ attrs }">
      <v-btn v-bind="attrs" @click="reset_snackbar">
        閉じる
      </v-btn>
    </template>
  </v-snackbar>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { Toast } from '~/store/toaster'
import { ToasterStore } from '~/store'

@Component
export default class Toaster extends Vue {
  snackbar = false

  get toast (): Toast {
    return ToasterStore.getToast
  }

  get show_snackbar (): boolean {
    this.snackbar = !!this.toast.message
    return this.snackbar
  }

  set show_snackbar (val: boolean) {
    this.reset_snackbar()
    this.snackbar = val
  }

  reset_snackbar (): void {
    ToasterStore.resetToast()
  }

  beforeDestroy (): void {
    this.reset_snackbar()
  }
}
</script>

<style scoped>

</style>
