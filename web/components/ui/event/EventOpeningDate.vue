<template>
  <td class="text-center">
    <div
      v-if="event.isHeldSameDate"
      class="py-3"
    >
      {{ event.stringBeginDay }}<br>
      {{ event.stringBeginTime }}〜{{ event.stringEndTime }}
    </div>
    <div
      v-else
      class="py-3"
    >
      {{ event.stringBeginDay }} {{ event.stringBeginTime }}<br>
      〜{{ event.stringEndDay }} {{ event.stringEndTime }}
    </div>
  </td>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'nuxt-property-decorator'

@Component
export default class EventOpeningDate extends Vue {
  @Prop({ type: Object, required: true }) event!: Event
}
</script>

<style scoped>

</style>
