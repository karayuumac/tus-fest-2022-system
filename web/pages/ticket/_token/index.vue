<template>
  <v-container fluid>
    <v-card max-width="750px" min-width="500px" class="mx-auto">
      <CardHeader class="no-print" />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          チケット
        </h3>
        <v-divider class="mt-2" />

        <v-row class="mt-4 mb-2">
          <span class="blue--text ml-4 no-print">
            本画面を印刷するか、入場の際に画面をお見せください。
          </span>
          <v-btn
            outlined
            color="blue"
            class="ml-auto mr-4 no-print"
            @click="print"
          >
            印刷
          </v-btn>
        </v-row>
        <v-card id="ticket" class="mt-4">
          <div class="ticket-header-background">
            <v-img class="ticket-header-img" :src="require('~/static/logo_white.svg')" />
            <v-card-title class="white--text d-flex flex-column align-end">
              <span>2022年度野田地区理大祭</span>
              <h3>デジタルチケット</h3>
              <h4 v-if="data.event.isHeldSameDate" class="mt-3">
                {{ data.event.getName }} ({{ data.event.stringBeginDay }} {{
                  data.event.stringBeginTime
                }}〜{{ data.event.stringEndTime }})
              </h4>
              <h4 v-else class="mt-3">
                {{ data.event.getName }} ({{ data.event.stringBeginDay }} {{ data.event.stringBeginTime }} 〜
                {{ data.event.stringEndDay }} {{ data.event.stringEndTime }})
              </h4>
            </v-card-title>
          </div>
          <v-card-text>
            <div class="mt-4">
              <QRCode class="qrcode" error-level="H" :text="data.token" />
              <div class="black--text text-center mt-2">
                {{ data.token }}
              </div>
            </div>

            <v-divider class="mt-4" />

            <div class="mt-4 pa-2 black--text">
              <ul>
                <li>当日受付にて本QRコードをご提示ください。</li>
                <li class="mt-3">
                  同じチケットで２度以上入場することはできません。
                </li>
              </ul>
            </div>
          </v-card-text>
        </v-card>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import QRCode from 'vue-qrcode-component/src/QRCode.vue'
import { Event } from '~/data/Event'
import CardHeader from '~/components/ui/CardHeader.vue'
import redirectIfNotValidToken from '~/middleware/ticket/redirectIfNotValidToken'

@Component({
  components: { CardHeader, QRCode },
  middleware: [redirectIfNotValidToken],
  head: {
    title: '電子チケット'
  }
})
export default class Index extends Vue {
  data = {
    event: {},
    token: ''
  }

  get token () {
    return this.$route.params.token
  }

  async mounted () {
    this.data = await this.$axios
      .$get(`/api/ticket/${this.token}`)
      .then((res) => {
        const rawEvent = res.event
        return {
          event: new Event(
            rawEvent.id,
            rawEvent.name,
            rawEvent.application_start_date,
            rawEvent.due_date,
            rawEvent.begin_date,
            rawEvent.end_date,
            Number.parseInt(rawEvent.price),
            rawEvent.status,
            rawEvent.max_reservation_count
          ),
          token: res.token
        }
      })
  }

  print () {
    window.print()
  }
}
</script>

<style lang="scss">
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}

.ticket-header-background {
  background: #23c3dd;
  height: 150px;
}

.ticket-header-img {
  position: absolute;
  left: 20px;
}

img {
  margin-right: auto !important;
  margin-left: auto !important;
}

@page {
  size: A4 portrait;
}

html {
  @media print {
    -webkit-print-color-adjust: exact;
    .no-print {
      display: none;
    }
  }
}
</style>
