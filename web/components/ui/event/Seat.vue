<template>
  <div
    :class="getClass"
    @click="select"
  />
</template>

<script lang="ts">
import { Component, Emit, Model, Prop, Vue } from 'nuxt-property-decorator'

@Component
export default class Seat extends Vue {
  @Prop({ type: String, required: true }) row!: string
  @Prop({ type: Number, required: true }) col!: number
  @Model('update', { type: Boolean, default: false }) hasSold!: boolean
  @Model('update', { type: Boolean, required: true }) selected!: boolean

  get getClass () {
    if (this.hasSold) {
      return 'seat-sold'
    } else if (this.selected) {
      return 'seat-selected'
    } else {
      return 'seat'
    }
  }

  @Emit()
  select () {
    if (this.hasSold) {
      return null
    }
    return {
      enable: !this.selected,
      seatName: this.row + '-' + this.col
    }
  }
}
</script>

<style lang="scss" scoped>
.seat {
  width: 16px;
  height: 24px;
  border-radius: 2px;
  border: 1px solid black;
  background: white;
}

.seat-selected {
  @extend .seat;
  background: #2196F3;
}

.seat-sold {
  @extend .seat;
  background: black;
}
</style>
