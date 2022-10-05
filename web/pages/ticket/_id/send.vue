<template>
  <v-container fluid>
    <v-card max-width="750px" min-width="500px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          チケットの譲渡
        </h3>
        <v-divider class="mt-2" />
        <div class="pa-2">
          以下のURLをメールなどで送信してください。<br>
          <span class="blue--text font-weight-bold">
            チケットの不正利用を防止するため、このURLは不特定多数に公開しないでください。
          </span>
        </div>

        <v-form>
          <v-container>
            <v-row>
              <v-col cols="12">
                <v-text-field
                  id="ticket-url"
                  label="チケット表示用URL"
                  :value="ticket_url"
                  :append-icon="mdi_content_copy"
                  readonly
                  outlined
                  @click:append="copy"
                />
              </v-col>
            </v-row>
          </v-container>
        </v-form>

        <v-row class="mb-2">
          <v-btn
            outlined
            color="blue"
            class="mx-auto"
            @click="$router.push('/reserve')"
          >
            チケット一覧画面へ
          </v-btn>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { mdiContentCopy } from '@mdi/js'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import redirectIfNotOwnToken from '~/middleware/ticket/redirectIfNotOwnToken'
import CardHeader from '~/components/ui/CardHeader.vue'
import { ToasterStore } from '~/utils/store-accsessor'

@Component({
  components: { CardHeader },
  middleware: [redirectIfNotVerified, redirectIfNotOwnToken],
  head: {
    title: 'チケットの譲渡'
  }
})
export default class Send extends Vue {
  mdi_content_copy = mdiContentCopy
  ticket_url = ''

  get id () {
    return this.$route.params.id
  }

  mounted () {
    this.$axios
      .$get(`/api/ticket/${this.id}/send`)
      .then((res) => {
        this.ticket_url = res.url
      })
  }

  async copy () {
    await navigator.clipboard.writeText(this.ticket_url)
    ToasterStore.setToast({
      message: 'クリップボードにコピーしました',
      color: 'success',
      timeout: 3000
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
