<template>
  <div class="text-center mx-4">
    <span
      :class="{
        'font-weight-bold text-center': true,
        'grey--text text--lighten-1': event.isBeforeApplication || event.hasFinishedApplication,
        'blue--text text--darken-2': event.isFree && event.isInApplication,
        'green--text text--darken-1': !event.isFree && event.isInApplication,
        'red--text text--lighten-1': event.isInLottery || event.hasFinishedLottery
      }"
    >
      <span>{{ event.getStatusMessage }}</span>
    </span>
    <br>
    <div v-if="event.isBeforeApplication">
      {{ event.stringApplicationStartDay }} {{ event.stringApplicationStartTime }}〜
    </div>
    <div v-if="event.isInApplication">
      〜{{ event.stringDueDay }} {{ event.stringDueTime }}
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'nuxt-property-decorator'

@Component
export default class EventStatusCol extends Vue {
  @Prop({ type: Object, required: true }) event!: Event
}
</script>

<style scoped>

</style>
