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
          登録されたメールアドレスを入力し、「パスワードのリセット」ボタンをクリックしてください。<br>
          登録されたメールアドレス宛に、パスワードリセット用URLをお送りします。
        </p>
        <v-form ref="form" @submit.prevent>
          <v-text-field
            v-model="email"
            type="email"
            label="登録メールアドレス"
            :rules="email_rules"
            placeholder="example@example.com"
            autocomplete="email"
            required
          />
        </v-form>

        <v-row class="mt-4 mb-2">
          <SingleSubmitButton
            class="mx-auto"
            :on-click="sendResetPasswordMail"
          >
            パスワードのリセット
          </SingleSubmitButton>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '@/components/ui/CardHeader.vue'
import RegisterStepper from '@/components/ui/RegisterStepper.vue'
import SingleSubmitButton from '@/components/ui/SingleSubmitButton.vue'
import { ToasterStore } from '@/utils/store-accsessor'
import { email_rules } from '@/utils/rules'
import { VFormInterface } from '~/interface/VFormInterface'
@Component({
  components: { SingleSubmitButton, RegisterStepper, CardHeader },
  head: {
    title: 'パスワードのリセット'
  }
})
export default class Reset extends Vue {
  email = ''
  email_rules = email_rules

  async sendResetPasswordMail () {
    if (!(this.$refs.form as VFormInterface).validate()) {
      ToasterStore.setToast({
        message: 'メールアドレスを正しく入力してください',
        timeout: 3000,
        color: 'error'
      })
    } else {
      await this.$axios.get('sanctum/csrf-cookie')
      await this.$axios.post(
        'auth/forgot-password',
        {
          email: this.email
        }
      )
        .then(() => {
          ToasterStore.setToast({
            message: 'パスワードリセットメールを送信しました',
            timeout: 3000,
            color: 'success'
          })
          this.$router.push('/')
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
