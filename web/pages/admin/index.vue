<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center mt-3">
          入場スキャン
        </h3>
        <v-divider class="mt-2" />
        <v-simple-table class="pa-2">
          <template #default>
            <thead>
              <tr>
                <th class="text-center">
                  名称
                </th>
                <th class="text-center">
                  開催日時
                </th>
                <th class="text-center">
                  スキャン
                </th>
              </tr>
            </thead>
            <tbody>
              <template v-for="event in events">
                <EventScanTableRow
                  :key="event.getId"
                  :event="event"
                />
              </template>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import CardHeader from '~/components/ui/CardHeader.vue'
import EventTableRow from '~/components/ui/event/EventTableRow.vue'
import { Event } from '~/data/Event'
import redirectIfNotAdmin from '~/middleware/admin/redirectIfNotAdmin'
import EventScanTableRow from '~/components/ui/admin/event/EventScanTableRow.vue'

export interface EventInterface {
  id: number,
  name: string,
  application_start_date: string,
  due_date: string,
  begin_date: string,
  end_date: string,
  price: string,
  status: string,
  visible: string,
  can_reserve: boolean,
  max_reservation_count: number,
  is_full: boolean
}

@Component({
  components: { EventScanTableRow, EventTableRow, CardHeader },
  middleware: [redirectIfNotVerified, redirectIfNotAdmin],
  head: {
    title: 'ホーム'
  }
})
export default class AdminIndex extends Vue {
  events: Event[] = []

  mounted () {
    this.$axios
      .$get('/api/event')
      .then((res: {data: EventInterface[]}) => {
        for (const event of res.data) {
          this.events.push(
            new Event(
              event.id,
              event.name,
              event.application_start_date,
              event.due_date,
              event.begin_date,
              event.end_date,
              Number.parseInt(event.price),
              event.status,
              event.can_reserve,
              event.max_reservation_count,
              event.is_full
            )
          )
        }
      })
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}

th {
  font-size: 14px !important;
}
</style>
