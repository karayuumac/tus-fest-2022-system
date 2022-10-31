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
              入場の際に必要となるQRコード&circledR;チケットです。最大{{ event.getMaxReservationCount }}枚（{{ event.getMaxReservationCount }}名様分）までまとめて予約・購入できます。
              <span class="blue--text font-weight-bold">
                必ず注意事項をお読みの上、予約・購入を行ってください。
              </span>
            </div>
          </v-card-text>

          <v-divider class="mx-4" />

          <v-card-text>
            <span class="subheading">
              <span>
                予約枚数を選択してください
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
            <v-dialog
              v-model="dialog"
              width="400px"
            >
              <template #activator="{ on, attr }">
                <v-btn
                  block
                  class="white--text font-weight-bold"
                  color="blue"
                  v-bind="attr"
                  v-on="on"
                >
                  <span>
                    予約する
                  </span>
                </v-btn>
              </template>
              <v-card>
                <v-card-title>
                  <span class="text-h6">
                    予約の確認
                  </span>
                </v-card-title>
                <v-card-text>
                  {{ event.getName }}のチケットを{{ selection }}名分予約します<br>
                  予約しますか？
                </v-card-text>
                <v-card-actions>
                  <v-spacer />
                  <v-btn
                    color="red"
                    text
                    @click="dialog = false"
                  >
                    キャンセル
                  </v-btn>
                  <v-btn
                    color="blue"
                    text
                    @click="reserve"
                  >
                    予約する
                  </v-btn>
                </v-card-actions>
              </v-card>
            </v-dialog>
          </v-card-actions>
        </v-card>
        <SeatSelector v-else :max-selection="event.getMaxReservationCount" :price="event.getPrice" />

        <h3 class="text-center mt-3">
          注意事項
        </h3>
        <v-divider class="mt-2" />
        <v-expansion-panels v-model="panel" accordion class="mt-4" multiple>
          <v-expansion-panel>
            <v-expansion-panel-header>
              予約・購入にあたって
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>
                  <span class="blue--text font-weight-bold">
                    一度予約・購入されたチケットのキャンセルは原則として承ることができません。
                  </span>
                </li>
                <li class="mt-3">
                  <span class="blue--text font-weight-bold">
                    予約は１アカウントにつき１回のみ可能です。
                  </span>
                </li>
                <li class="mt-3">
                  予約・購入内容をよくご確認の上、予約・購入をお願いいたします。
                </li>
                <li class="mt-3">
                  予約・購入されたチケットの譲渡は、身内や知人などの限定的な範囲に限られるものとします。
                  <span class="blue--text font-weight-bold">
                    予約・購入されたチケットの転売は固くお断りいたします。
                  </span>
                </li>
                <li class="mt-3">
                  万が一当日参加されない場合であっても、連絡等は不要です。
                </li>
              </ul>
            </v-expansion-panel-content>
          </v-expansion-panel>

          <v-expansion-panel>
            <v-expansion-panel-header>
              入場方法について
            </v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>発行されるチケットはQRコード&circledR;形式です。</li>
                <li class="mt-3">
                  チケットは代表者様がまとめて予約・購入することも可能です。
                  <ul>
                    <li class="mt-3">
                      入場にあたっては、<span class="blue--text font-weight-bold">１人１枚</span>のチケットが必要です。
                    </li>
                    <li class="mt-3">
                      予約・購入した枚数分のチケットを、「予約・購入チケット一覧」画面にて同行者様に譲渡することが可能です。
                    </li>
                  </ul>
                </li>
                <li class="mt-3">
                  入場時、QRコード&circledR;が表示された画面、または事前に画面を印刷したものを受付にてご提示ください。
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
                  有料にて開催するイベントは、<span class="blue--text font-weight-bold">購入時に代金をお支払いいただきます</span>。
                  また、お支払い方法は<span class="blue--text font-weight-bold">クレジットカードのみ</span>とさせていただきます。あらかじめご了承ください。
                </li>
                <li class="mt-3">
                  有料にて開催するイベントは、購入を希望する座席を選択の上、「購入する」ボタンをクリックしてください。
                  クレジットカード番号の入力画面に移動しましたら、クレジットカード番号・名義・CVCをご入力の上、「支払う」をクリックしてください。
                  <ul class="mt-3">
                    <li>
                      クレジットカード番号入力画面におけるCVCには、セキュリティコード（カード裏面の3桁ないし4桁の番号）をご入力ください。
                    </li>
                  </ul>
                </li>
                <li class="mt-3">
                  新型コロナウイルスの感染拡大等により、大学側より収容人数の制限を設けられた場合、一部の座席の利用を制限させていただく場合がございます。あらかじめご了承ください。
                  <ul class="mt-3">
                    <li>その場合、該当する座席を予約された方にはメールにてご連絡の上、キャンセル・返金をさせていただきます。</li>
                  </ul>
                </li>
                <li class="mt-3">
                  <a href="/transaction" target="_blank">特定商取引法に基づく表記</a>も合わせてご覧ください。
                </li>
              </ul>
            </v-expansion-panel-content>
          </v-expansion-panel>
        </v-expansion-panels>

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
import SeatSelector from '~/components/ui/event/SeatSelector.vue'

@Component({
  components: { SeatSelector, SingleSubmitButton, EventStatusCol, EventOpeningDate, CardHeader },
  middleware: [redirectIfNotVerified, redirectIfNotApplication],
  head: {
    title: 'イベント情報'
  }
})
export default class EventIndex extends Vue {
  dialog = false
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
          rawEvent.can_reserve,
          rawEvent.max_reservation_count,
          rawEvent.is_full
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
      .then((_) => {
        this.dialog = false
        this.$router.push('/home')
        ToasterStore.setToast({
          message: '予約しました',
          color: 'success',
          timeout: 3000
        })
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

#change-mark {
  li {
    list-style-type: none;
    &::before {
      content: "※";
    }
  }
}
</style>
