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

@Component({
  middleware: 'auth'
})
export default class About extends Vue {
  name = ''
  email = ''

  mounted () {
    console.info(this.$auth.user)
  }

  logout (): void {
  }
}
</script>
