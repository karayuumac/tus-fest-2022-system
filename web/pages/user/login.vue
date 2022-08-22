<template>
  <v-container fluid>
    <v-card max-width="700px" class="mx-auto">
      <v-card-title class="text-center justify-center">
        ログイン
      </v-card-title>
      <v-divider />
      <v-card-text>
        <v-container>
          <v-form ref="form" @submit.prevent>
            <v-text-field
              v-model="email"
              type="email"
              label="メールアドレス"
              :rules="email_rules"
              placeholder="example@example.com"
              autocomplete="email"
              autofocus
              required
            />
            <v-text-field
              v-model="password"
              :append-icon="show_password ? mdi_eye : mdi_eye_off"
              :type="show_password ? 'text' : 'password'"
              autocomplete="password"
              label="パスワード"
              :rules="password_rules"
              required
              @click:append="show_password = !show_password"
            />
            <v-row justify="center" class="mt-1">
              <v-btn
                variant="outlined"
                color="primary"
                class="justify-center"
                data-cy="button"
                @click="login"
              >
                ログイン
              </v-btn>
            </v-row>
          </v-form>
        </v-container>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'vue-property-decorator'
import { mdiEye, mdiEyeOff } from '@mdi/js'
import { VFormInterface } from '~/interface/VFormInterface'
import { ToasterStore } from '~/store'

@Component({
  middleware: 'auth'
})
export default class Login extends Vue {
  email = ''
  password = ''
  show_password = false
  mdi_eye = mdiEye
  mdi_eye_off = mdiEyeOff
  email_rules = [
    (email: string): boolean | string => !!email || 'メールアドレスを入力してください.'
  ]

  password_rules = [
    (password: string): boolean | string => !!password || 'パスワードを入力してください.'
  ]

  login (): void {
    if (!(this.$refs.form as VFormInterface).validate()) {
      ToasterStore.setToast({
        message: 'ユーザー名またはパスワードを正しく入力してください',
        timeout: 3000,
        color: 'error'
      })
    } else {
      this.$auth
        .loginWith('laravelSanctum', {
          data: {
            email: this.email,
            password: this.password
          }
        })
        .then(() => {
          ToasterStore.setToast({
            message: 'ログインに成功しました！',
            timeout: 3000,
            color: 'success'
          })
          this.$router.push('/home')
        })
        .catch(() => {
          ToasterStore.setToast({
            message: 'メールアドレスまたはパスワードが正しくありません',
            timeout: 3000,
            color: 'error'
          })
        })
    }
  }
}
</script>

<style scoped>

</style>
