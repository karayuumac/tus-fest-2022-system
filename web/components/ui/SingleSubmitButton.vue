<template>
  <v-btn
    color="blue"
    :block="block"
    :loading="loading"
    :outlined="outlined"
    :disabled="disabled || processing"
    @click="handleClick"
  >
    <slot />
  </v-btn>
</template>

<script lang="ts">
import { Component, Model, Prop, Vue } from 'nuxt-property-decorator'

@Component
export default class SingleSubmitButton extends Vue {
  @Prop({ type: Function, required: true }) onClick!: Function
  @Prop({ type: Boolean, default: false }) disabled!: boolean
  @Prop({ type: Boolean, default: false }) block!: boolean
  @Prop({ type: Boolean, default: false }) outlined!: boolean
  @Model('update', { type: Boolean, default: false }) loading!: boolean

  processing = false

  handleClick (event: Event): void {
    if (this.processing) {
      return
    }
    this.processing = true
    this.onClick(event)
      .then(() => {
        this.processing = false
      })
  }
}
</script>

<style scoped>

</style>
