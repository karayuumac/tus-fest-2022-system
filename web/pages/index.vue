<template>
  <v-container fluid>
    <v-card max-width="700px" min-width="400px" class="mx-auto">
      <CardHeader title="ポータルサイト" />

      <v-card-text class="font-size-normal">
        <div>2022年度の野田地区理大祭は、事前予約によるチケット入場制といたします。</div>
        <div class="mt-2">
          理大祭への参加を希望される方は、下記の注意事項をお読みの上、事前予約を行ってください。
        </div>
        <v-expansion-panels v-model="panel" accordion class="mt-4" multiple>
          <v-expansion-panel>
            <v-expansion-panel-header>学外からお越しの方（在校生のご家族を含む）</v-expansion-panel-header>
            <v-expansion-panel-content>
              <ul>
                <li>来場者の人数把握のために、学外からお越しの方は事前に本システムによる来場予約をお願いしております。</li>
                <li class="mt-3">
                  来場者の人数により、<span class="blue--text font-weight-bold">入場制限等を設ける場合がございます</span>。あらかじめご了承ください。
                </li>
              </ul>
              <v-row class="mt-3 mb-2">
                <v-btn
                  outlined
                  color="blue"
                  class="mx-auto"
                  @click="$router.push('register/condition')"
                >
                  事前予約を行う
                </v-btn>
              </v-row>
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
  components: { CardHeader }
})
export default class Register extends Vue {
  panel = [0]
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
}
</style>
