<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          理大祭情報
        </h3>
        <v-divider class="mt-2" />
        <v-simple-table class="pa-2">
          <template #default>
            <tbody>
              <tr>
                <td class="text-center">
                  名称
                </td>
                <td class="text-center">
                  2022年度東京理科大学野田地区理大祭
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  開催期間
                </td>
                <td class="text-center">
                  2022年11月26日（土）・27日（日）
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  開催場所
                </td>
                <td class="text-center">
                  東京理科大学 野田キャンパス<br>
                  <a
                    href="https://www.tus.ac.jp/access/noda_campus/"
                    target="_blank"
                  >
                    アクセス情報はこちら
                  </a>
                </td>
              </tr>
              <tr>
                <td class="text-center">
                  公式ホームページ
                </td>
                <td class="text-center">
                  <a
                    href="https://www.tus.ac.jp/access/noda_campus/"
                    target="_blank"
                  >
                    https://www.tus.ac.jp/access/noda_campus/
                  </a>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>

        <h3 class="text-center mt-3">
          予約情報
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
                  状態
                </th>
                <th />
              </tr>
            </thead>
            <tbody>
              <template v-for="event in events">
                <EventTableRow
                  :key="event.getId"
                  :event="event"
                />
              </template>
            </tbody>
          </template>
        </v-simple-table>
        <v-btn @click="logout">
          ログアウト
        </v-btn>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { AxiosResponse } from 'axios'
import { ToasterStore } from '~/utils/store-accsessor'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import CardHeader from '~/components/ui/CardHeader.vue'
import EventTableRow from '~/components/ui/event/EventTableRow.vue'
import { Event } from '~/data/Event'

interface EventInterface {
  id: number,
  name: string,
  application_start_date: string,
  due_date: string,
  begin_date: string,
  end_date: string,
  price: string,
  status: string,
  visible: string
}

@Component({
  components: { EventTableRow, CardHeader },
  middleware: [redirectIfNotVerified],
  head: {
    title: 'ホーム'
  }
})
export default class Home extends Vue {
  events: Event[] = []

  mounted () {
    this.$axios
      .get<any, any>('/api/event')
      .then((res: AxiosResponse<{data: EventInterface[]}>) => {
        for (const event of res.data.data) {
          this.events.push(
            new Event(
              event.id,
              event.name,
              event.application_start_date,
              event.due_date,
              event.begin_date,
              event.end_date,
              Number.parseInt(event.price),
              event.status
            )
          )
        }
      })
  }

  logout (): void {
    this.$auth.logout()
    ToasterStore.setToast({
      message: 'ログアウトしました',
      timeout: 3000,
      color: 'success'
    })
    this.$router.push('/')
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
