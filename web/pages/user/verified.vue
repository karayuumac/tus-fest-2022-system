<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <RegisterStepper v-model="step" />
        <h3 class="mt-5 text-center">
          メールアドレスの確認
        </h3>
        <v-divider class="mt-2" />
        <p class="mt-2">
          登録されたメールアドレスに確認メールを送信しました。<br>
          メール内のリンクをクリックし、メールアドレスの確認を行ってください。<br>
          確認メールが届いていない場合、「確認メールを再送信する」をクリックしてください。
        </p>
        <v-row class="mt-4 mb-2">
          <SingleSubmitButton
            class="mx-auto"
            :on-click="resendVerificationMail"
          >
            確認メールを再送信する
          </SingleSubmitButton>
        </v-row>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script>
import { Component, Vue } from 'nuxt-property-decorator'
import CardHeader from '@/components/ui/CardHeader'
import RegisterStepper from '@/components/ui/RegisterStepper'
import SingleSubmitButton from '@/components/ui/SingleSubmitButton'
import { ToasterStore } from '@/utils/store-accsessor'
import redirectIfVerified from '@/middleware/redirectIfVerified'

@Component({
  components: { SingleSubmitButton, RegisterStepper, CardHeader },
  middleware: [redirectIfVerified]
})
export default class Verified extends Vue {
  step = 3

  async resendVerificationMail () {
    await this.$axios.get('sanctum/csrf-cookie')
    await this.$axios.post(
      'auth/email/verification-notification'
    )
      .then(() => {
        ToasterStore.setToast({
          message: '確認メールを再送信しました',
          timeout: 3000,
          color: 'success'
        })
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
