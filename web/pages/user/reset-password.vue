<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <h3 class="text-center">
          パスワードのリセット
        </h3>
        <v-divider class="mt-2" />
        <p class="mt-2">
          新しいパスワードを入力し、「パスワードを再設定」ボタンをクリックしてください。
        </p>
        <v-form ref="form" @submit.prevent>
          <v-text-field
            type="email"
            label="登録メールアドレス"
            disabled
            :value="$route.query.email"
            autocomplete="email"
            required
          />

          <v-text-field
            v-model="password"
            :append-icon="show_password ? mdi_eye : mdi_eye_off"
            :type="show_password ? 'text' : 'password'"
            label="パスワード"
            :rules="password_rules"
            autocomplete="new-password"
            required
            @click:append="show_password = !show_password"
          />

          <v-text-field
            v-model="password_confirmation"
            :append-icon="show_password_confirmation ? mdi_eye : mdi_eye_off"
            :type="show_password_confirmation ? 'text' : 'password'"
            label="パスワード（確認）"
            :rules="password_confirmation_rules(password)"
            autocomplete="new-password"
            required
            @click:append="show_password_confirmation = !show_password_confirmation"
          />
        </v-form>

        <v-row class="mt-4 mb-2">
          <SingleSubmitButton
            class="mx-auto"
            :on-click="resetPassword"
          >
            パスワードを再設定
          </SingleSubmitButton>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { mdiEye, mdiEyeOff } from '@mdi/js'
import CardHeader from '@/components/ui/CardHeader.vue'
import RegisterStepper from '@/components/ui/RegisterStepper.vue'
import SingleSubmitButton from '@/components/ui/SingleSubmitButton.vue'
import { ToasterStore } from '@/utils/store-accsessor'
import { password_rules } from '@/utils/rules'
import { VFormInterface } from '~/interface/VFormInterface'
import redirectIfNotValidQueries from '~/middleware/reset-password/redirectIfNotValidQueries'

@Component({
  components: { SingleSubmitButton, RegisterStepper, CardHeader },
  middleware: [redirectIfNotValidQueries],
  head: {
    title: 'パスワードのリセット'
  }
})
export default class ResetPassword extends Vue {
  email = ''
  password = ''
  password_confirmation = ''

  show_password = false
  show_password_confirmation = false

  mdi_eye = mdiEye
  mdi_eye_off = mdiEyeOff

  password_rules = password_rules
  password_confirmation_rules = (password: string) => [
    (password_confirmation: string): boolean | string =>
      !!password_confirmation || 'パスワードを再入力してください.',
    (password_confirmation: string): boolean | string =>
      password_confirmation === password || 'パスワードが一致しません.'
  ]

  async resetPassword () {
    if (!(this.$refs.form as VFormInterface).validate()) {
      ToasterStore.setToast({
        message: 'パスワードを正しく入力してください',
        timeout: 3000,
        color: 'error'
      })
    } else {
      await this.$axios.get('sanctum/csrf-cookie')
      await this.$axios.post(
        'auth/reset-password',
        {
          email: this.$route.query.email,
          token: this.$route.query.token,
          password: this.password,
          password_confirmation: this.password_confirmation
        }
      )
        .then(() => {
          ToasterStore.setToast({
            message: 'パスワードをリセットしました',
            timeout: 3000,
            color: 'success'
          })
          this.$router.push('/user/login')
        })
        .catch((err) => {
          ToasterStore.setToast({
            message: err.response.data.message,
            timeout: 3000,
            color: 'error'
          })
        })
    }
  }
}
</script>

<style lang="scss" scoped>
.font-size-normal {
  font-size: 16px;
  line-height: 25px;
}
</style>
