<template>
  <tr>
    <td class="text-center">
      <h4>{{ event.getName }}</h4>
    </td>
    <EventOpeningDate
      :event="event"
    />
    <td>
      <EventStatusCol
        :event="event"
      />
    </td>
    <td>
      <EventButton :event="event" />
    </td>
  </tr>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'nuxt-property-decorator'
import EventOpeningDate from '~/components/ui/event/EventOpeningDate.vue'
import EventStatusCol from '~/components/ui/event/EventStatusCol.vue'
import EventButton from '~/components/ui/event/EventButton.vue'

@Component({
  components: { EventButton, EventStatusCol, EventOpeningDate }
})
export default class EventTableRow extends Vue {
  @Prop({ type: Object, required: true }) event!: Event
}
</script>

<style scoped>

</style>
