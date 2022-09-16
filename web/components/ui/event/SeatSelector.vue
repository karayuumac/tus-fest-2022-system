<template>
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
              :selected="isSelected(row.name, i)"
              :has-sold="hasSold(row.name, i)"
              @select="onSelected"
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
              :selected="isSelected(row.name, i + 7)"
              :has-sold="hasSold(row.name, i + 7)"
              @select="onSelected"
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
              :selected="isSelected(row.name, i + 18)"
              :has-sold="hasSold(row.name, i + 18)"
              @select="onSelected"
            />
            <div v-else class="spacer" />
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script lang="ts">
import { Component, Prop, Vue } from 'nuxt-property-decorator'
import { SeatRow, seatRows } from '~/const/SeatRows'
import Seat from '~/components/ui/event/Seat.vue'
@Component({
  components: { Seat }
})
export default class SeatSelector extends Vue {
  @Prop({ type: Number, default: 4 }) maxSelection!: number

  selection: string[] = []

  sold: string[] = []
  seatRows: SeatRow[] = seatRows

  mounted () {
    this.sold = [
      'A-18', 'B-15', 'B-19'
    ]
  }

  hasSold (row: string, col: number) {
    return this.sold.filter((value) => {
      return value === row + '-' + col
    }).length > 0
  }

  isSelected (row: string, col: number) {
    return this.selection.filter((value) => {
      return value === row + '-' + col
    }).length > 0
  }

  onSelected (selectedSeat: { enable: boolean, seatName: string }) {
    if (selectedSeat) {
      if (selectedSeat.enable) {
        if (this.selection.length >= this.maxSelection) {
          return
        }
        this.selection.push(selectedSeat.seatName)
      } else {
        // 本来, リストからの要素の削除はパフォーマンスの低下につながるが, 今回は高々数個の選択であるため問題ないと判断する.
        this.selection.forEach((elem, index) => {
          if (elem === selectedSeat.seatName) {
            this.selection.splice(index, 1)
          }
        })
      }
    }
    console.info(this.selection)
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
</style>
