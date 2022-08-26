<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <RegisterStepper v-model="step" />
        <v-form class="mt-4" @submit.prevent>
          <div>
            2022年度の野田地区理大祭に参加される
            <span class="blue--text font-weight-bold">学外からお越しの方</span>
            は、下記の注意事項をご確認の上、チェックボックスにチェックを入れてユーザー登録に進んでください。
          </div>
          <v-expansion-panels v-model="panel_1" accordion class="mt-4" multiple>
            <v-expansion-panel>
              <v-expansion-panel-header>予約の対象者</v-expansion-panel-header>
              <v-expansion-panel-content>
                本予約の対象者は、以下の条件を全て満たす方です。
                <ol class="mt-4">
                  <li>学外の方である（<span class="blue--text font-weight-bold">本学の学生ではない</span>）こと</li>
                  <li class="mt-2">
                    2022年度東京理科大学野田地区理大祭（11月〇〇日開催）に参加する予定であること
                  </li>
                </ol>
              </v-expansion-panel-content>
            </v-expansion-panel>

            <v-expansion-panel>
              <v-expansion-panel-header>ユーザー登録に関する注意事項</v-expansion-panel-header>
              <v-expansion-panel-content>
                <ul>
                  <li>
                    グループで来場される場合、
                    <span class="blue--text font-weight-bold">代表者がユーザー登録を行ってください</span>
                    。
                  </li>
                </ul>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>

          <v-row class="mt-2">
            <v-checkbox v-model="confirm_condition" class="mx-auto" label="上記の条件・注意事項を確認した" />
          </v-row>

          <v-expansion-panels v-model="panel_2" accordion class="mt-4" multiple>
            <v-expansion-panel>
              <v-expansion-panel-header>新型コロナウイルス感染症対策に関するお願い</v-expansion-panel-header>
              <v-expansion-panel-content>
                2022年度野田地区理大祭（以下、理大祭という。）に参加するにあたって、
                新型コロナウイルス感染症対策に関する以下のお願いを遵守いただきますようご協力をお願いいたします。
                <ol class="mt-4">
                  <li>参加にあたっては、当日自宅において検温をしていただき、発熱等の風邪の症状がみられる場合は、理大祭に参加しないでください。</li>
                  <li class="mt-2">
                    理大祭参加日１週間前以降に体調不良や濃厚接触・感染の疑いがある場合は、理大祭に参加しないでください。<br>
                    また、同居家族や身近な知人に感染の疑いがないことを確認してください。
                  </li>
                  <li class="mt-2">
                    新型コロナウイルス接触確認アプリ（COCOA）の使用をお願いいたします。<br>
                    （ただし、使用している携帯電話がCOCOAに対応していない場合、あるいは携帯電話をお持ちでない場合は必要ありません。）
                  </li>
                  <li class="mt-2">
                    理大祭参加にあたっては、必ずマスクを着用してください。（不織布を推奨します。）<br>
                    また、大声を発することはご遠慮いただき、密集を避けていただくようお願いいたします。
                  </li>
                  <li class="mt-2">
                    理大祭参加にあたっては、受付において検温・手指消毒のご協力をお願いいたします。
                  </li>
                  <li class="mt-2">
                    飲食スペースにおいては、密を避けるため短時間の利用をお願いいたします。<br>
                    また、黙食を基本とし、会話をする際は必ずマスクを着用していただきますようお願いいたします。
                  </li>
                  <li class="mt-2">
                    理大祭参加後は、複数人で集まっての会食等はせず、速やかに個々に帰宅するようご協力をお願いいたします。
                  </li>
                </ol>
              </v-expansion-panel-content>
            </v-expansion-panel>
          </v-expansion-panels>

          <v-row class="mt-2">
            <v-checkbox
              v-model="confirm_covid_term"
              class="mx-auto"
              label="「新型コロナウイルス感染症対策に関するお願い」を確認し、同意する"
            />
          </v-row>

          <v-row class="pb-3">
            <v-btn
              outlined
              color="blue"
              :disabled="!confirm_condition || !confirm_covid_term"
              class="mx-auto"
              @click="goToRegisterUser"
            >
              <span v-if="!confirm_condition || !confirm_covid_term">
                チェックボックスにチェックを入れてください
              </span>
              <span v-else>
                ユーザー登録に進む
              </span>
            </v-btn>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '~/components/ui/CardHeader.vue'
import RegisterStepper from '~/components/ui/RegisterStepper.vue'
import redirectIfAuthenticated from '~/middleware/redirectIfAuthenticated'

@Component({
  components: { RegisterStepper, CardHeader },
  middleware: [redirectIfAuthenticated]
})
export default class Condition extends Vue {
  step = 1

  panel_1 = [0, 1]
  panel_2 = [0]

  confirm_condition = false
  confirm_covid_term = false

  goToRegisterUser () {
    this.$router.push('/user/create?condition=true')
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}

.v-breadcrumbs {
  padding-left: 4px;
  padding-top: 12px;
}

.scrollable {
  padding-top: 8px;
  margin-bottom: 8px;
  height: 400px;
  overflow-y: auto;
}
</style>
