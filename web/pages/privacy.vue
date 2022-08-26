<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          2022年度野田地区理大祭来場者予約システム利用規約
        </h3>
        <v-divider class="mt-2" />

        <p class="mt-4">
          この利用規約（以下、「本規約」という。）は、2022年度東京理科大学野田地区理大祭実行委員会（以下、「実行委員会」という。）の
          来場者予約システム（以下、「本システム」という。）を利用するにあたって、ユーザー登録ならびに来場予約を行う者（以下、「ユーザー」という。）
          が同意する必要のある項目を定めることを目的としたものです。
        </p>

        <h4 class="mt-4">
          第１条（適用）
        </h4>
        <v-divider class="mt-2" />
        <div class="mt-4">
          <ol>
            <li>
              本規約は、ユーザーと実行委員会との間の本システムの利用に関わる一切の関係に適用されるものとします。
            </li>
            <li class="mt-2">
              実行委員会は、本システムの利用にあたって、本規約の他、必要とされる各種の定め（以下、「個別規約」という。）をすることがあります。<br>
              これらの個別規約は、その名称のいかんに関わらず、本規約の一部を構成するものとします。
            </li>
            <li class="mt-2">
              本規約の規定が、個別規定で定められた規定と矛盾する場合、個別規定において特段の定めがない限り、個別規定の規定が優先されるものとします。
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
