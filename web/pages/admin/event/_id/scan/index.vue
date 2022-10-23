<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center mt-3">
          スキャン
        </h3>
        <v-divider class="mt-2" />
        <ul class="mt-3 black--text">
          <li>
            チケットのQRコードをカメラで読み取らせてください。
          </li>
        </ul>

        <qrcode-stream class="qrcode-stream mt-4 mx-auto" @decode="onDecode" @init="onInit" />

        <v-simple-table id="info" class="mt-4 pa-4">
          <template #default>
            <tbody>
              <tr>
                <td class="font-weight-bold black--text text-center">
                  チケットID
                </td>
                <td>
                  <transition name="fade" mode="out-in">
                    <span :key="token">{{ token }}</span>
                  </transition>
                </td>
              </tr>
              <tr>
                <td class="font-weight-bold black--text text-center">
                  判定
                </td>
                <transition name="fade" mode="out-in">
                  <td
                    :key="token"
                    :class="[is_error ? 'red--text bg-error' : 'blue--text bg-success', 'font-weight-bold']"
                  >
                    {{ message }}
                  </td>
                </transition>
              </tr>
            </tbody>
          </template>
        </v-simple-table>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { QrcodeStream } from 'vue-qrcode-reader'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'
import CardHeader from '~/components/ui/CardHeader.vue'
import redirectIfNotAdmin from '~/middleware/admin/redirectIfNotAdmin'

@Component({
  components: { CardHeader, QrcodeStream },
  middleware: [redirectIfNotVerified, redirectIfNotAdmin],
  head: {
    title: 'ホーム'
  }
})
export default class AdminIndex extends Vue {
  event_id = this.$route.params.id
  token = ''
  message = ''
  is_error = false

  async onInit (promise: any) {
    try {
      this.is_error = false
      await promise
    } catch (error: any) {
      this.is_error = true
      if (error.name === 'NotAllowedError') {
        this.message = 'エラー: カメラの利用権限を許可してください.'
      } else if (error.name === 'NotFoundError') {
        this.message = 'エラー: カメラが見つかりません.'
      } else if (error.name === 'NotSupportedError') {
        this.message = 'エラー: セキュリティの状況によりカメラを利用できません.'
      } else if (error.name === 'NotReadableError') {
        this.message = 'エラー: すでにカメラが利用されています.'
      } else if (error.name === 'OverconstrainedError') {
        this.message = 'ERROR: installed cameras are not suitable'
      } else if (error.name === 'StreamApiNotSupportedError') {
        this.message = 'ERROR: Stream API is not supported in this browser'
      } else if (error.name === 'InsecureContextError') {
        this.message = 'ERROR: Camera access is only permitted in secure context. Use HTTPS or localhost rather than HTTP.'
      } else {
        this.message = `ERROR: Camera error (${error.name})`
      }
    }
  }

  onDecode (result: string) {
    this.token = result

    this.$axios
      .$post(`/api/admin/event/${this.event_id}/scan`, {
        token: this.token
      })
      .then((res) => {
        this.is_error = false
        this.message = res.message
      })
      .catch((err) => {
        this.is_error = true
        this.message = err.response.data.message
      })
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}

.qrcode-stream {
  max-width: 400px;
}

#info {
  td:first-child {
    max-width: 100px;
  }
  td {
    font-size: 16px !important;
  }
}

.bg-error {
  background: rgba(205, 92, 92, 0.3);
}

.bg-success {
  background: rgba(0, 255, 255, 0.3);
}

.fade-enter-active, .fade-leave-active {
  transition: opacity .4s;
}

.fade-enter, .fade-leave-to {
  opacity: 0;
}
</style>
