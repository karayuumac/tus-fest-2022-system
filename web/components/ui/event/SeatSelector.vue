<template>
  <div>
    <ul class="ml-2 mt-3 black--text">
      <li>
        購入を希望する座席をクリックして選択してください。
        選択された座席は青色で表示されます。
      </li>
      <li class="mt-3 font-weight-bold blue--text">
        座席は{{ maxSelection }}席まで購入できます。
      </li>
      <li class="mt-3">
        黒色で表示された座席はすでに販売済みまたは販売されていない座席です。
      </li>
    </ul>
    <div id="stage">
      <div class="white--text text-center my-10 font-weight-bold">
        ステージ
      </div>
      <div class="divider" />
      <table id="seats">
        <tbody>
          <tr
            v-for="row in seatRows"
            :key="row.name"
            class="mb-2"
          >
            <td>
              <span class="white--text font-weight-bold mr-3">
                {{ row.name }}
              </span>
            </td>
            <td v-for="i in 7" :key="i">
              <Seat
                v-if="row.left !== 0 && i >= (7 - row.left)"
                :row="row.name"
                :col="i"
                :has-sold="hasSold(row.name, i)"
              />
              <div v-else class="spacer" />
            </td>

            <td>
              <div class="spacer" />
            </td>

            <td v-for="i in 11" :key="i + 7">
              <Seat
                v-if="row.center !== 0"
                :row="row.name"
                :col="i + 7"
                :has-sold="hasSold(row.name, i + 7)"
              />
            </td>

            <td>
              <div class="spacer" />
            </td>

            <td v-for="i in 7" :key="i + 18">
              <Seat
                v-if="i <= row.right"
                :row="row.name"
                :col="i + 18"
                :has-sold="hasSold(row.name, i + 18)"
              />
              <div v-else class="spacer" />
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div>
      <v-simple-table v-if="selection.length !== 0" class="pa-4">
        <template #default>
          <thead>
            <tr>
              <th class="text-center">
                座席番号
              </th>
              <th class="text-center">
                金額
              </th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="seat in selection" :key="seat">
              <td class="text-center font-weight-bold">
                {{ seat }}
              </td>
              <td class="text-center font-weight-bold">
                {{ price.toLocaleString('jp') }} 円
              </td>
            </tr>
          </tbody>
        </template>
      </v-simple-table>

      <div v-if="selection.length !== 0" class="d-flex flex-row mx-4 my-2">
        <div class="black--text font-weight-bold font-size-total-price ml-8">
          合計
        </div>
        <v-spacer />
        <div class="black--text font-weight-bold font-size-total-price mr-8">
          {{ (price * selection.length).toLocaleString('jp') }} 円
        </div>
      </div>
      <v-divider v-if="selection.length !== 0" class="mx-8" />

      <v-row v-if="selection.length !== 0" class="mt-4 mb-4">
        <SingleSubmitButton
          outlined
          :loading="loading"
          class="mx-auto"
          :on-click="click"
        >
          購入する
        </SingleSubmitButton>
      </v-row>
    </div>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'nuxt-property-decorator'
import { StripeCheckout } from '@vue-stripe/vue-stripe'
import { SeatRow, seatRows } from '~/const/SeatRows'
import Seat from '~/components/ui/event/Seat.vue'
import { SeatSelectionStore, ToasterStore } from '~/utils/store-accsessor'
import SingleSubmitButton from '~/components/ui/SingleSubmitButton.vue'

export interface SeatData {
  row: number,
  col: number
}

@Component({
  components: { SingleSubmitButton, Seat, StripeCheckout }
})
export default class SeatSelector extends Vue {
  @Prop({ type: Number, default: 4 }) maxSelection!: number
  @Prop({ type: Number, required: true }) price!: number

  // 0-index は使用しない.
  soldSeats: SeatData[] = []

  seatRows: SeatRow[] = seatRows

  loading = false

  async mounted () {
    const pendingSeats =
      await this.$axios
        .$get(`/api/event/${this.eventId}/seat/reserved`)
        .then((res) => {
          return res
        })
    if (pendingSeats.data.length !== 0) {
      await this.$axios
        .$post(`/api/event/${this.eventId}/seat/release`)
      // キャンセル処理
      ToasterStore
        .setToast({
          message: '購入をキャンセルしました.',
          timeout: 3000,
          color: 'error'
        })
    }
    SeatSelectionStore.initialize(this.maxSelection)
    this.loadReservedSeats()
  }

  get eventId () {
    return this.$route.params.id
  }

  get selection () {
    return SeatSelectionStore.getSelection
  }

  loadReservedSeats () {
    this.soldSeats.splice(0)
    this.$axios
      .$get(`/api/event/${this.eventId}/seat/reserved/all`)
      .then((res) => {
        for (let i = 0; i < res.data.length; i++) {
          const seat = res.data[i]
          this.soldSeats.push({
            row: seat.row,
            col: seat.col
          })
        }
      })
  }

  toNumber (row: string): number {
    return row.charCodeAt(0) - 'A'.charCodeAt(0) + 1
  }

  hasSold (row: string, col: number) {
    const numRow = this.toNumber(row)
    return this.soldSeats.some((seat) => {
      return seat.row === numRow && seat.col === col
    })
  }

  async click () {
    this.loading = true
    await this.$axios
      .$post(`/api/event/${this.eventId}/seat/reserve`, {
        seats: SeatSelectionStore.getSelectionInArray
      })
      .then((res) => {
        window.location.replace(res.redirect_to)
      })
      .catch((err) => {
        this.loadReservedSeats()
        ToasterStore
          .setToast({
            message: err.response.data.message,
            timeout: 3000,
            color: 'error'
          })
      })
    SeatSelectionStore.reset()
    this.loading = false
  }
}
</script>

<style lang="scss" scoped>
#stage {
  margin: 16px auto;
  background: grey;
  border: 4px solid black;
  width: fit-content;
}

.divider {
  height: 2px;
  background: white;
}

#seats {
  margin: 16px;
}

.spacer {
  width: 16px;
  height: 24px;
}

.font-size-total-price {
  font-size: 24px;
}

tr {
  th {
    font-size: 14px !important;
  }
  td {
    font-size: 16px !important;
  }
}
</style>
