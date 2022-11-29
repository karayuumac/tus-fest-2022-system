<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          予約・購入チケット一覧
        </h3>
        <v-divider class="mt-2" />

        <div v-if="isLoading" class="text-center mt-2">
          <v-progress-circular
            indeterminate
            color="blue"
          />
        </div>

        <div v-else-if="Object.keys(tickets).length !== 0" class="pa-2">
          <v-card v-for="ticket in tickets" :key="ticket.id" min-width="250" class="mx-2 my-4">
            <v-card-title class="font-weight-bold">
              {{ ticket.event.getName }}（ID: {{ ticket.id }}）
            </v-card-title>
            <v-card-subtitle>
              <div
                v-if="ticket.event.isHeldSameDate"
                class="py-3"
              >
                {{ ticket.event.stringBeginDay }}<br>
                {{ ticket.event.stringBeginTime }}〜{{ ticket.event.stringEndTime }}
              </div>
              <div
                v-else
                class="py-3"
              >
                {{ ticket.event.stringBeginDay }} {{ ticket.event.stringBeginTime }}<br>
                〜{{ ticket.event.stringEndDay }} {{ ticket.event.stringEndTime }}
              </div>
            </v-card-subtitle>
            <v-card-text>
              <v-row class="mx-4 mb-2">
                <v-col
                  cols="12"
                  lg="6"
                  class="d-flex justify-center"
                >
                  <v-btn
                    v-if="!ticket.is_assigned"
                    color="green"
                    outlined
                    @click="$router.push(`/ticket/${ticket.id}/send`)"
                  >
                    チケットを譲渡する
                  </v-btn>
                  <v-btn
                    v-else
                    color="orange"
                    outlined
                    @click="stopSharing(ticket.id)"
                  >
                    チケットの譲渡をやめる
                  </v-btn>
                </v-col>
                <v-col
                  cols="12"
                  lg="6"
                  class="d-flex justify-center"
                >
                  <v-btn
                    v-if="!ticket.is_assigned"
                    color="blue"
                    outlined
                    @click="$router.push(`/ticket/${ticket.ticket_token}`)"
                  >
                    チケットを表示する
                  </v-btn>
                  <v-btn
                    v-else
                    color="blue"
                    disabled
                    outlined
                    @click="$router.push(`/ticket/${ticket.ticket_token}`)"
                  >
                    譲渡チケットは表示できません
                  </v-btn>
                </v-col>
              </v-row>
            </v-card-text>
          </v-card>
        </div>

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
  isLoading = true

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
      .then(() => {
        this.isLoading = false
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
