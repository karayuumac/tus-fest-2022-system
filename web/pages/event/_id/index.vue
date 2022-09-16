<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text v-if="event" class="font-size-normal">
        <h3 class="text-center">
          イベント情報
        </h3>
        <v-divider class="mt-2" />
        <v-simple-table class="pa-2">
          <template #default>
            <tbody>
              <tr>
                <td class="text-center font-weight-bold">
                  イベント名
                </td>
                <td class="text-center">
                  <span class="py-3 font-weight-bold">
                    {{ event.getName }}
                  </span>
                </td>
              </tr>
              <tr>
                <td class="text-center font-weight-bold">
                  開催日時
                </td>
                <EventOpeningDate :event="event" />
              </tr>
              <tr>
                <td class="text-center font-weight-bold">
                  <span v-if="event.isFree">予約期間</span>
                  <span v-else>販売期間</span>
                </td>
                <td>
                  <EventStatusCol class="py-3" :event="event" />
                </td>
              </tr>
              <tr>
                <td class="text-center font-weight-bold">
                  価格
                </td>
                <td class="text-center">
                  {{ formattedPrice }}
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>

        <h3 class="text-center mt-3">
          <span v-if="event.isFree">予約</span>
          <span v-else>購入</span>
        </h3>
        <v-divider class="mt-2" />

        <v-card
          v-if="event.isFree"
          class="my-4 mx-auto"
          max-width="370px"
        >
          <v-card-title>事前予約チケット</v-card-title>

          <v-card-text>
            <div>
              入場の際に必要となるQRコードチケットです。最大{{ event.getMaxReservationCount }}枚（{{ event.getMaxReservationCount }}名様分）までまとめて予約・購入できます。
              <span class="blue--text font-weight-bold">
                必ず注意事項をお読みの上、予約・購入を行ってください。
              </span>
            </div>
          </v-card-text>

          <v-divider class="mx-4" />

          <v-card-text>
            <span class="subheading">
              <span v-if="event.isFree">
                予約枚数を選択してください
              </span>
              <span v-else>
                購入枚数を選択してください
              </span>
            </span>

            <v-chip-group
              v-model="selection"
              class="mt-2"
              active-class="blue white--text"
              mandatory
              column
            >
              <v-chip
                v-for="i in event.getMaxReservationCount"
                :key="i"
                :value="i"
              >
                {{ i }} 枚
              </v-chip>
            </v-chip-group>
          </v-card-text>

          <v-card-actions>
            <SingleSubmitButton
              block
              class="white--text font-weight-bold"
              :on-click="reserve"
            >
              <span v-if="event.isFree">
                予約する
              </span>
              <span v-else>
                購入する
              </span>
            </SingleSubmitButton>
          </v-card-actions>
        </v-card>
        <SeatSelector v-else />

        <h3 class="text-center mt-3">
          注意事項
        </h3>
        <v-divider class="mt-2" />
        <v-expansion-panels v-model="panel" accordion class="mt-4" multiple>
          <v-expansion-panel>
            <v-expansion-panel-header>
              入場方法について
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>発行されるチケットはQRコード形式です。</li>
                <li class="mt-3">
                  チケットは代表者様がまとめて予約・購入することも可能です。
                  <ul>
                    <li class="mt-3">
                      入場にあたっては、<span class="blue--text font-weight-bold">１人１枚</span>のチケットが必要です。
                    </li>
                    <li class="mt-3">
                      予約・購入した枚数分のチケットを、「チケット確認画面」にてメールで送信・印刷することが可能です。
                    </li>
                  </ul>
                </li>
                <li class="mt-3">
                  入場時、QRコードが表示された画面、または事前に画面を印刷したものを受付にてご提示ください。
                </li>
              </ul>
            </v-expansion-panel-content>
          </v-expansion-panel>

          <v-expansion-panel>
            <v-expansion-panel-header>
              抽選について
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>チケットの発行枚数によっては、抽選を行うことがございます。抽選を行うかどうかは予約受付期間・販売受付期間が終了した後に判断いたします。</li>
                <li class="mt-3">
                  抽選を行わない場合、チケットは<span class="blue--text font-weight-bold">予約受付期間・販売受付期間が終了した後に発行されます</span>。
                </li>
                <li class="mt-3">
                  抽選を行う場合、「トップページ」（ログイン直後の画面）にてお知らせいたします。
                  <ul>
                    <li class="mt-3">
                      抽選を行う場合、<span class="blue--text font-weight-bold">予約受付期間・販売受付期間が終了した後に抽選を行います</span>。<br>
                      抽選に当選された場合にのみチケットを表示・印刷することが可能です。
                    </li>
                  </ul>
                </li>
                <li class="mt-3">
                  代表者様がまとめて複数枚のチケットを予約・購入された場合、抽選は予約・購入された複数枚のチケット単位で行われます。
                  <ul>
                    <li class="mt-3">
                      例えば代表者様が２枚のチケットを予約・購入された場合、１枚のチケットが当選し、もう１枚のチケットが落選することはありません。<br>
                      ２枚のチケットがともに当選するか、落選するかの２パターンとなります。
                    </li>
                    <li class="mt-3">
                      抽選システムの関係上、１枚のチケットを予約・購入された場合と、２枚以上のチケットをまとめて予約・購入された場合の当選確率が異なる場合がございます。あらかじめご了承ください。
                    </li>
                  </ul>
                </li>
              </ul>
            </v-expansion-panel-content>
          </v-expansion-panel>

          <v-expansion-panel>
            <v-expansion-panel-header>
              有料チケットの販売方法について
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>一部有料にて開催するイベントがございます。イベント情報の「価格」欄をご覧ください。</li>
                <li class="mt-3">
                  有料にて開催するイベントは、<span class="blue--text font-weight-bold">受付にて代金をお支払いいただきます</span>。
                  また、お支払い方法は<span class="blue--text font-weight-bold">現金のみ</span>とさせていただきます。あらかじめご了承ください。
                </li>
                <li class="mt-3">
                  <a href="/transaction" target="_blank">特定商取引法に基づく表記</a>も合わせてご覧ください。
                </li>
              </ul>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '~/components/ui/CardHeader.vue'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import redirectIfNotApplication from '~/middleware/event/redirectIfNotInApplication'
import { Event } from '~/data/Event'
import EventOpeningDate from '~/components/ui/event/EventOpeningDate.vue'
import EventStatusCol from '~/components/ui/event/EventStatusCol.vue'
import SingleSubmitButton from '~/components/ui/SingleSubmitButton.vue'
import { ToasterStore } from '~/utils/store-accsessor'
import SeatSelector from "~/components/ui/event/SeatSelector.vue";

@Component({
  components: {SeatSelector, SingleSubmitButton, EventStatusCol, EventOpeningDate, CardHeader },
  middleware: [redirectIfNotVerified, redirectIfNotApplication]
})
export default class EventIndex extends Vue {
  panel = [0, 1, 2]
  selection = 0
  event: Event = null as unknown as Event

  get eventId () {
    return this.$route.params.id
  }

  async created () {
    const event_id = this.eventId
    await this.$axios
      .$get(`/api/event/${event_id}`)
      .then((res) => {
        const rawEvent = res.data
        this.event = new Event(
          rawEvent.id,
          rawEvent.name,
          rawEvent.application_start_date,
          rawEvent.due_date,
          rawEvent.begin_date,
          rawEvent.end_date,
          Number.parseInt(rawEvent.price),
          rawEvent.status,
          rawEvent.max_reservation_count
        )
      })
  }

  get formattedPrice () {
    if (this.event.isFree) {
      return '無料'
    } else {
      return this.event.getPrice.toLocaleString('ja') + ' 円'
    }
  }

  async reserve () {
    const event_id = this.eventId
    await this.$axios
      .$post(`/api/event/${event_id}/reserve`, {
        number_of_people: this.selection
      })
      .then((res) => {
        // redirect
      })
      .catch((err) => {
        ToasterStore
          .setToast({
            message: err.response.data.message,
            timeout: 3000,
            color: 'error'
          })
      })
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}

tr {
  td {
    &:nth-child(2) {
      font-size: 16px !important;
    }
  }
}

.border {
  border: 1px solid #BDBDBD;
}
</style>
