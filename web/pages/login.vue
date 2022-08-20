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
              <v-btn variant="outlined" color="primary" class="justify-center" @click="login">
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
import { getModule } from 'vuex-module-decorators'
import ToasterModule from '~/store/toaster'
import { VFormInterface } from '~/interface/VFormInterface'
import { ToasterStore } from '~/store'

@Component
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

  onclick (): void {
    const toast_module = getModule(ToasterModule, this.$store)
    toast_module.setToast({
      message: 'テスト',
      timeout: -1,
      color: 'error'
    })
  }

  login (): void {
    if (!(this.$refs.form as VFormInterface).validate()) {
      ToasterStore.setToast({
        message: 'ユーザー名またはパスワードを正しく入力してください',
        timeout: 3000,
        color: 'error'
      })
    } else {
      /* const auth = getAuth()
      signInWithEmailAndPassword(auth, this.email, this.password)
        .then((userCredential) => {
          const user = userCredential.user
          AuthStore.setUser({
            userUid: user.uid,
            isLoggedIn: true
          })
          this.$router.push('/about')
          ToasterStore.setToast({
            message: 'ログインに成功しました',
            timeout: 3000,
            color: 'success'
          })
        })
        .catch(() => {
          ToasterStore.setToast({
            message: 'ユーザー名またはパスワードが異なります',
            timeout: 3000,
            color: 'error'
          })
        }) */

      this.$auth.loginWith('laravelSanctum', {
        data: {
          email: this.email,
          password: this.password
        }
      })
        .then((res) => {
          console.info(res)
          ToasterStore.setToast({
            message: 'ログインに成功しました！',
            timeout: 3000,
            color: 'success'
          })
          this.$router.push('/about')
        })
        .catch(() => {
          ToasterStore.setToast({
            message: 'メールアドレスまたはパスワードが正しくありません',
            timeout: 3000,
            color: 'error'
          })
        })

      /* this.$auth
        .loginWith('laravelSanctum', {
          data: {
            email: this.email,
            password: this.password
          }
        })
        .then((res) => {
          ToasterStore.setToast({
            message: res ? res.data.message : '',
            timeout: 3000,
            color: 'success'
          })
          console.info(this.$auth.user)
          this.$router.push('/about')
        })
        .catch((err) => {
          ToasterStore.setToast({
            message: err.response.data.message,
            timeout: 3000,
            color: 'error'
          })
        })
    } */
    }
  }
}
</script>

<style scoped>

</style>
