<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader :show-back-button="false" />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          特定商取引法に基づく表示
        </h3>
        <v-divider class="mt-2" />

        <p class="mt-4">
          2022年度東京理科大学野田地区理大祭実行委員会では、「特定商取引に関する法律」第11条（通信販売についての広告）に基づき、以下の通り明示いたします。
        </p>

        <v-simple-table class="pa-2">
          <template #default>
            <tbody>
              <tr>
                <td>
                  事業者名
                </td>
                <td>
                  2022年度東京理科大学野田地区理大祭実行委員会
                </td>
              </tr>
              <tr>
                <td>
                  事業者所在地
                </td>
                <td>
                  &#12306;278-0022<br>
                  千葉県野田市山崎2641 部室棟E-209 学生会本部
                </td>
              </tr>
              <tr>
                <td>
                  代表者
                </td>
                <td>
                  木村真心
                </td>
              </tr>
              <tr>
                <td>
                  電話番号
                </td>
                <td>
                  04-7124-9880<br>
                  ※現在、新型コロナウイルス感染症対策としてお電話でのお問い合わせの受付を停止しております。
                  お手数をおかけいたしますが、メールにてお問合せ頂きますようご協力をお願いいたします。
                </td>
              </tr>
              <tr>
                <td>
                  メールアドレス
                </td>
                <td>
                  <a href="mailto:support@nodaridaisai.net">support@nodaridaisai.net</a>
                </td>
              </tr>
              <tr>
                <td>
                  販売価格（役務の対価）
                </td>
                <td>
                  各イベントページの「価格」欄に記載されている価格とします。
                </td>
              </tr>
              <tr>
                <td>
                  代金（対価）の支払い時期<br>
                  支払い方法
                </td>
                <td>
                  チケット購入時にお支払いいただきます。<br>
                  支払い方法はクレジットカードのみとなります。
                </td>
              </tr>
              <tr>
                <td>
                  予約・販売成立時期
                </td>
                <td>
                  予約終了画面が表示された時点で無料イベントの場合は予約が、有料イベントの場合は販売が成立したものとします。
                </td>
              </tr>
              <tr>
                <td>
                  役務の提供時期
                </td>
                <td>
                  各イベントページの「開催日時」欄をご覧ください。
                </td>
              </tr>
              <tr>
                <td>
                  返金
                </td>
                <td>
                  サービスの特性上、イベント終了後の返金はできません。
                </td>
              </tr>
              <tr>
                <td>
                  契約の申し込みの撤回（キャンセル）
                </td>
                <td>
                  予約・販売が成立した後の申し込みの撤回（キャンセル）はできません。<br>
                  ただし、実行委員会側の責めに帰すべき場合にはキャンセル・返金をいたします。
                </td>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '~/components/ui/CardHeader.vue'
@Component({
  components: { CardHeader },
  head: {
    title: '特定商取引法に基づく表示'
  }
})
export default class Transaction extends Vue {
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}
tr {
  td {
    &:nth-child(1) {
      font-weight: bold;
      text-align: center;
    }

    padding: 8px 16px !important;
    max-width: 300px;
  }
}
</style>
