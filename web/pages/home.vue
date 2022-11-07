<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader :show-back-button="false" />
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
                    href="https://nodaridaisai.com/2022"
                    target="_blank"
                  >
                    https://nodaridaisai.com/2022
                  </a>
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>

        <v-alert
          class="mt-2 mb-4"
          border="left"
          colored-border
          type="warning"
          elevation="2"
        >
          来場予約・本予約システムに関するお問い合わせは、<a href="mailto:support@nodaridaisai.net">support@nodaridaisai.net</a>までお願いいたします。<br>
          大学側の業務に支障をきたす恐れがございますので、<span class="font-weight-bold blue--text">東京理科大学への直接のお問い合わせはご遠慮いただきますよう</span>、ご協力をお願いいたします。
        </v-alert>

        <h3 class="text-center mt-3">
          イベント情報
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

        <h3 class="text-center mt-3">
          予約状況の確認
        </h3>
        <v-divider class="mt-2" />
        <div class="mt-2 pa-2 black--text">
          予約状況の確認では、以下のことが行えます。
          <ul>
            <li>予約・購入したチケットの確認</li>
            <li>予約・購入したチケットの譲渡</li>
          </ul>
        </div>
        <v-row class="mt-4 mb-2">
          <v-btn
            outlined
            color="blue"
            class="mx-auto"
            @click="$router.push('/reserve')"
          >
            予約の確認はこちら
          </v-btn>
        </v-row>

        <div v-if="$auth.user.data.is_admin">
          <h3 class="text-center mt-5">
            管理者モード
          </h3>
          <v-divider class="mt-2" />
          <div class="mt-2 pa-2 black--text">
            管理者モードでは、以下のことが行えます。
            <ul>
              <li>入場スキャン</li>
            </ul>
          </div>
          <v-row class="mt-4 mb-2">
            <v-btn
              outlined
              color="blue"
              class="mx-auto"
              @click="$router.push('/admin')"
            >
              管理者モードはこちら
            </v-btn>
          </v-row>
        </div>

        <h3 class="text-center mt-5">
          ログアウト
        </h3>
        <v-divider class="mt-2" />
        <div class="mt-2 pa-2 black--text">
          以下のボタンからログアウトすることが可能です。再度ログインする場合は、メールアドレスとパスワードが必要です。
        </div>
        <v-row class="mt-4 mb-2">
          <v-btn
            outlined
            color="red"
            class="mx-auto"
            @click="logout"
          >
            ログアウト
          </v-btn>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { ToasterStore } from '~/utils/store-accsessor'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import CardHeader from '~/components/ui/CardHeader.vue'
import EventTableRow from '~/components/ui/event/EventTableRow.vue'
import { Event } from '~/data/Event'

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
