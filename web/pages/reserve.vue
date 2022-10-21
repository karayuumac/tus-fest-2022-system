<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          予約・購入チケット一覧
        </h3>
        <v-divider class="mt-2" />

        <v-simple-table v-if="Object.keys(tickets).length !== 0" class="pa-2">
          <template #default>
            <thead>
              <tr>
                <th class="text-center">
                  チケットID
                </th>
                <th class="text-center">
                  名称
                </th>
                <th class="text-center">
                  開催日時
                </th>
                <th class="text-center">
                  操作
                </th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="ticket in tickets" :key="ticket.id">
                <td class="text-center">
                  {{ ticket.id }}
                </td>
                <td class="text-center">
                  <h4>{{ ticket.event.getName }}</h4>
                </td>
                <EventOpeningDate
                  :event="ticket.event"
                />
                <td>
                  <div class="d-flex flex-column pa-4">
                    <v-btn
                      v-if="!ticket.is_assigned"
                      class="mb-2"
                      color="green"
                      outlined
                      @click="$router.push(`/ticket/${ticket.id}/send`)"
                    >
                      チケットを譲渡する
                    </v-btn>
                    <v-btn
                      v-else
                      class="mb-2"
                      color="orange"
                      outlined
                      @click="stopSharing(ticket.id)"
                    >
                      チケットの譲渡をやめる
                    </v-btn>
                    <v-btn
                      v-show="!ticket.is_assigned"
                      class="mt-2"
                      color="blue"
                      outlined
                      @click="$router.push(`/ticket/${ticket.ticket_token}`)"
                    >
                      チケットを表示する
                    </v-btn>
                  </div>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>

        <div v-else class="text-center mt-4">
          予約・購入済みのチケットはありません
        </div>

        <v-row class="mt-3 mb-2">
          <v-btn
            class="mx-auto"
            outlined
            color="blue"
            @click="$router.push('/home')"
          >
            ホームに戻る
          </v-btn>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '~/components/ui/CardHeader.vue'
import { Event } from '~/data/Event'
import EventOpeningDate from '~/components/ui/event/EventOpeningDate.vue'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'

interface Response {
  id: string,
  type: 'reserve' | 'seat'
  event: Event,
  ticket_token: string
  is_assigned: boolean
}

type Responses = {
  [id: string]: Response
}

@Component({
  components: { EventOpeningDate, CardHeader },
  head: {
    title: '予約・購入チケット一覧'
  },
  middleware: [redirectIfNotVerified]
})
export default class Reserve extends Vue {
  tickets: Responses = {}

  mounted () {
    this.$axios
      .$get('/api/ticket')
      .then((res) => {
        for (const data of res.data) {
          this.$set(this.tickets, data.id, {
            id: data.id,
            type: data.type === 'seat' ? 'seat' : 'reserve',
            event: new Event(
              data.event.id,
              data.event.name,
              data.event.application_start_date,
              data.event.due_date,
              data.event.begin_date,
              data.event.end_date,
              Number.parseInt(data.event.price),
              data.event.status,
              data.event.can_reserve,
              data.event.max_reservation_count,
              data.event.is_full
            ),
            ticket_token: data.ticket_token,
            is_assigned: data.is_assigned
          })
        }
      })
  }

  stopSharing (ticketId: string) {
    this.$axios
      .$get(`/api/ticket/${ticketId}/stop-sharing`)
    this.tickets[ticketId].is_assigned = false
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}
</style>
