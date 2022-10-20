<template>
  <v-app>
    <v-app-bar app>
      <v-app-bar-title>
        <h5 class="d-flex flex-column">
          <span class="text-small">
            2022年度
          </span>
          野田地区理大祭
        </h5>
      </v-app-bar-title>
    </v-app-bar>
    <v-main>
      <v-container>
        <toaster />
        <Nuxt />
        <GoTopButton />
      </v-container>
    </v-main>
    <v-footer app>
      <h5>&copy; 東京理科大学野田地区理大祭実行委員会 {{ new Date().getFullYear() }}</h5>
      <div class="ml-auto">
        <a
          href="/terms"
          class="mr-3"
          target="_blank"
        >
          利用規約
        </a>
        <a href="/transaction" target="_blank">
          特定商取引法に基づく表示
        </a>
      </div>
    </v-footer>
  </v-app>
</template>

<script>
import { Component, Vue } from 'nuxt-property-decorator'
import Toaster from '@/components/ui/Toaster'
import GoTopButton from '~/components/ui/GoTopButton'

@Component({
  name: 'DefaultLayout',
  components: {
    GoTopButton,
    Toaster
  }
})
export default class Default extends Vue {
}
</script>

<style lang="scss" scoped>
  .text-small {
    font-size: .75em;
  }
</style>
