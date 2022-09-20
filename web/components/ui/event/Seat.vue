<template>
  <div
    :class="getClass"
    @click="select"
  />
</template>

<script lang="ts">
import { Component, Model, Prop, Vue } from 'nuxt-property-decorator'
import { SeatSelectionStore } from '~/utils/store-accsessor'

@Component
export default class Seat extends Vue {
  @Prop({ type: String, required: true }) row!: string
  @Prop({ type: Number, required: true }) col!: number
  @Model('update', { type: Boolean, default: false }) hasSold!: boolean

  get getSeatName () {
    return this.row + '-' + this.col
  }

  get getClass () {
    if (this.hasSold) {
      return 'seat-sold'
    } else if (SeatSelectionStore.exists(this.getSeatName)) {
      return 'seat-selected'
    } else {
      return 'seat'
    }
  }

  select () {
    if (this.hasSold) {
      return null
    }
    if (!SeatSelectionStore.exists(this.getSeatName)) {
      SeatSelectionStore.insertSelection(this.getSeatName)
    } else {
      SeatSelectionStore.removeSelection(this.getSeatName)
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
