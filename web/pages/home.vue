<template>
  <div class="about">
    <p>名前: {{ name }}</p>
    <p>メールアドレス: {{ email }}</p>
    <v-btn outlined color="red" @click="logout">
      ログアウト
    </v-btn>
  </div>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { ToasterStore } from '~/utils/store-accsessor'
import redirectIfNotVerified from '~/middleware/redirectIfNotVerified'

@Component({
  middleware: [redirectIfNotVerified]
})
export default class Home extends Vue {
  name = ''
  email = ''

  logout (): void {
    this.$auth.logout()
    ToasterStore.setToast({
      message: 'ログアウトしました',
      timeout: 3000,
      color: 'success'
    })
    this.$router.push('/')
  }
}
</script>
