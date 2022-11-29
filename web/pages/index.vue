<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader :show-back-button="false" title="ポータルサイト" />

      <v-card-text class="font-size-normal">
        <p>
          2022年度の野田地区理大祭は、事前予約によるチケット入場制といたします。<br>
          理大祭への参加を希望される方は、下記の注意事項をお読みの上、事前予約を行ってください。
        </p>
        <v-expansion-panels v-model="panel" accordion class="mt-4" multiple>
          <v-expansion-panel>
            <v-expansion-panel-header>学外からお越しの方（本学学生のご家族を含む）</v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>来場者の人数把握のために、学外からお越しの方は事前に本システムによる来場予約をお願いしております。</li>
              </ul>
              <v-row v-if="!isLoggedIn" class="mt-4 mb-2">
                <v-col
                  cols="12"
                  lg="6"
                  class="d-flex justify-center"
                >
                  <v-btn
                    outlined
                    color="blue"
                    @click="$router.push('/user/condition')"
                  >
                    ユーザー登録を行う
                  </v-btn>
                </v-col>

                <v-col
                  cols="12"
                  lg="6"
                  class="d-flex justify-center"
                >
                  <v-btn
                    outlined
                    color="blue"
                    @click="$router.push('/user/login')"
                  >
                    ログインはこちら
                  </v-btn>
                </v-col>
              </v-row>

              <v-row v-else class="mt-4 mb-2">
                <v-col
                  cols="12"
                  class="d-flex justify-center"
                >
                  <v-btn
                    outlined
                    color="blue"
                    class="mx-auto"
                    @click="$router.push('/home')"
                  >
                    予約の確認はこちら
                  </v-btn>
                </v-col>
              </v-row>
            </v-expansion-panel-content>
          </v-expansion-panel>

          <v-expansion-panel>
            <v-expansion-panel-header>本学学生・教職員・理大祭関係者の方々</v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>本学学生・教職員・理大祭関係者の方々の入場予約は<span class="blue--text font-weight-bold">不要</span>です。</li>
                <li class="mt-3">
                  ただし、場合により実行委員から学生証・職員証の提示を求める場合があります。
                </li>
                <li class="mt-3">
                  なお、本学学生で、芸能人企画をご覧になりたい方は<span class="blue--text font-weight-bold">ユーザー登録を行った上で、「芸能人企画ライブチケット」をご購入ください。</span>
                  <ul class="mt-3">
                    <li>入場チケットを予約いただく必要はございません。</li>
                  </ul>
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

@Component({
  components: { CardHeader },
  head: {
    title: 'トップページ'
  }
})
export default class Index extends Vue {
  panel = [0, 1]
  isLoggedIn = false

  mounted () {
    this.isLoggedIn = this.$auth.loggedIn
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}
</style>
