<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          予約・購入完了
        </h3>
        <v-divider class="mt-2" />
        <div class="text-center font-weight-bold black--text pt-4">
          予約・購入が完了しました。
        </div>
        <v-layout justify-center align-center class="mt-6">
          <v-progress-circular
            rotate="-90"
            color="blue"
            :value="progress"
            size="150"
            width="7.5"
          >
            <v-icon
              color="blue"
              size="75"
              :style="{ opacity: opacity }"
            >
              {{ mdiCheck }}
            </v-icon>
          </v-progress-circular>
        </v-layout>
        <v-row class="mt-6 mb-2">
          <v-btn
            class="mx-auto"
            outlined
            color="blue"
            @click="$router.push('/reserves')"
          >
            予約・購入済みチケット一覧へ
          </v-btn>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import gsap from 'gsap'
import { mdiCheck } from '@mdi/js'
import CardHeader from '~/components/ui/CardHeader.vue'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'

@Component({
  components: { CardHeader },
  middleware: [redirectIfNotVerified],
  head: {
    title: '予約・購入完了'
  }
})
export default class Success extends Vue {
  progress = 0
  opacity = 0
  mdiCheck = mdiCheck

  mounted () {
    gsap.to(this.$data, {
      duration: 1,
      progress: 100
    })
    gsap.to(this.$data, {
      duration: 3,
      opacity: 1
    })
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}
</style>
