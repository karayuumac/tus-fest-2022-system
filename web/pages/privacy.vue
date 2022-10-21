<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader :show-back-button="false" />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          2022年度野田地区理大祭来場者予約システムプライバシーポリシー
        </h3>
        <v-divider class="mt-2" />

        <p class="mt-4">
          このプライバシーポリシー（以下、「本ポリシー」という。）は、2022年度東京理科大学野田地区理大祭実行委員会（以下、「実行委員会」という。）の
          来場者予約システム（以下、「本システム」という。）における、ユーザーについての個人情報を含む利用者情報の取り扱いについて定めるものです。
        </p>

        <h4 class="mt-4">
          １.収集する利用者情報および収集方法
        </h4>
        <v-divider class="mt-2" />
        <div class="mt-4">
          本ポリシーにおいて、「利用者情報」とは、ユーザーの識別に関わる情報・通信サービス上の行動履歴・その他ユーザーまたはユーザーの端末に関連して生成・集積された情報であって、
          本ポリシーに基づき実行委員会が収集するものを意味するものとします。
          本システムにおいて、実行委員会が収集する利用者情報は、その収集方法に応じて、以下のようなものとなります。
          <ol class="mt-2">
            <li>
              ユーザーからご提供いただく情報
              <p class="mt-2">
                本システムを利用するために、または本システムの利用を通じてユーザーからご提供いただく情報は以下の通りです。
              </p>
              <ul class="mt-2">
                <li class="mt-2">
                  氏名（漢字・よみ）のプロフィールに関する情報
                </li>
                <li class="mt-2">
                  メールアドレス・電話番号の連絡先に関する情報
                </li>
                <li class="mt-2">
                  クレジットカード情報の決済手段に関する情報
                </li>
                <li class="mt-2">
                  入力フォームや、その他実行委員会が定める方法を通じてユーザーが入力または送信する情報
                </li>
              </ul>
            </li>
          </ol>
        </div>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '~/components/ui/CardHeader.vue'

@Component({
  head: {
    title: 'プライバシーポリシー'
  },
  components: {
    CardHeader
  }
})
export default class Privacy extends Vue {

}
</script>

<style scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}
</style>
