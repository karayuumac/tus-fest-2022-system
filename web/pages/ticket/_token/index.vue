<template>
  <v-container fluid>
    <v-card min-width="450px" max-width="750px" class="mx-auto">
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
        <v-card id="ticket" min-width="400px" class="mt-4">
          <div class="ticket-header-background">
            <v-container class="ma-0">
              <v-row>
                <v-col class="pa-0" cols="4">
                  <v-img class="ticket-header-img" :src="require('~/static/logo_white.svg')" />
                </v-col>
                <v-col class="pa-0" cols="8">
                  <v-card-title class="white--text d-flex flex-column align-end">
                    <span>2022年度野田地区理大祭</span>
                    <h3>デジタルチケット</h3>
                    <h5 v-if="data.event.isHeldSameDate" class="mt-2">
                      {{ data.event.getName }} ({{ data.event.stringBeginDay }} {{
                        data.event.stringBeginTime
                      }}〜{{ data.event.stringEndTime }})
                    </h5>
                    <h5 v-else class="mt-2">
                      {{ data.event.getName }} ({{ data.event.stringBeginDay }} {{ data.event.stringBeginTime }} 〜
                      {{ data.event.stringEndDay }} {{ data.event.stringEndTime }})
                    </h5>
                  </v-card-title>
                </v-col>
              </v-row>
            </v-container>
          </div>
          <v-card-text>
            <div class="mt-4 mx-auto">
              <div v-if="!data.event.isFree" class="black--text text-center text-h5 mt-2">
                座席番号： <span class="font-weight-bold">{{ seat }}</span>
              </div>
              <div>
                <vue-qrcode v-if="data.token" class="d-block mx-auto" :value="data.token" :options="option" />
              </div>
              <div class="black--text text-center mt-2">
                {{ data.token }}
              </div>
            </div>

            <v-divider class="mt-4" />

            <div class="mt-4 pa-2 black--text">
              <ul>
                <li>当日受付にて本QRコード&circledR;をご提示ください。</li>
                <li v-if="!data.event.isFree" class="mt-3">
                  同じチケットで２度以上入場することはできません。
                </li>
              </ul>
            </div>

            <v-divider class="mt-3" />
            <div id="change-mark">
              <ul class="pl-4">
                <li class="mt-3">
                  QRコードは(株)デンソーウェーブの登録商標です。
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
import VueQrcode from '@chenfengyuan/vue-qrcode'
import { Event } from '~/data/Event'
import CardHeader from '~/components/ui/CardHeader.vue'
import redirectIfNotValidToken from '~/middleware/ticket/redirectIfNotValidToken'

@Component({
  components: { CardHeader, VueQrcode },
  middleware: [redirectIfNotValidToken],
  head: {
    title: '電子チケット'
  }
})
export default class Index extends Vue {
  data = {
    event: {},
    token: '',
    row: '',
    col: ''
  }

  option = {
    errorCorrectionLevel: 'H',
    scale: 6
  }

  get token () {
    return this.$route.params.token
  }

  get seat () {
    return String.fromCharCode('A'.charCodeAt(0) - 1 + parseInt(this.data.row)) + '-' + this.data.col
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
            rawEvent.can_reserve,
            rawEvent.max_reservation_count,
            rawEvent.is_full
          ),
          token: res.token,
          row: res.row,
          col: res.col
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
  width: 150px;
  height: auto;
  position: absolute;
  left: 10px;
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

#change-mark {
  li {
    list-style-type: none;
    &::before {
      content: "※";
    }
  }
}
</style>
