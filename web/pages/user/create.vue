<template>
  <v-container fluid>
    <v-card max-width="750px" class="mx-auto">
      <CardHeader />
      <v-card-text class="font-size-normal">
        <RegisterStepper v-model="step" />
        <div class="mt-4">
          ユーザー情報をご入力後、利用規約・プライバシーポリシーをお読みになり、「確認メールを送信する」をクリックしてください。
        </div>
        <h3 class="text-center mt-4">
          ユーザー情報
        </h3>
        <v-divider class="mt-2" />
        <v-form
          ref="form"
          class="mt-4"
        >
          <v-text-field
            v-model="email"
            type="email"
            label="メールアドレス"
            :rules="email_rules"
            placeholder="example@example.com"
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

          <v-row class="mt-2 px-3">
            <v-text-field
              v-model="family_name"
              class="mr-2"
              type="text"
              label="姓"
              :rules="family_name_rules"
              autocomplete="family-name"
              placeholder="理科大"
              required
            />

            <v-text-field
              v-model="given_name"
              class="ml-2"
              type="text"
              label="名"
              :rules="last_name_rules"
              autocomplete="given-name"
              placeholder="太郎"
              required
            />
          </v-row>

          <v-row class="mt-4 px-3">
            <v-text-field
              v-model="family_name_yomi"
              class="mr-2"
              type="text"
              label="セイ"
              :rules="family_name_yomi_rules"
              autocomplete="family-name"
              placeholder="リカダイ"
              required
            />

            <v-text-field
              v-model="given_name_yomi"
              class="ml-2"
              type="text"
              label="メイ"
              :rules="last_name_yomi_rules"
              autocomplete="given-name"
              placeholder="タロウ"
              required
            />
          </v-row>

          <div class="red--text mt-4">
            ※姓・名は登録後に変更できません。
          </div>

          <h3 class="text-center mt-4">
            連絡先情報
          </h3>
          <v-divider class="mt-2" />
          <v-text-field
            v-model="phone_number"
            type="text"
            label="電話番号（ハイフンあり）"
            :rules="phone_number_rules"
            autocomplete="tel"
            placeholder="090-1234-5678"
            required
          />

          <v-row class="mt-1">
            <v-checkbox
              v-model="confirm_terms"
              class="mx-auto"
            >
              <template #label>
                <div>
                  <a
                    target="_blank"
                    href="/terms"
                    @click.stop
                  >利用規約</a>
                  ・
                  <a
                    target="_blank"
                    href="/privacy"
                    @click.stop
                  >プライバシーポリシー</a>
                  に同意する
                </div>
              </template>
            </v-checkbox>
          </v-row>

          <v-row class="mt-4 mb-2">
            <SingleSubmitButton
              class="mx-auto"
              :disabled="!confirm_terms"
              :on-click="submit"
            >
              確認メールを送信する
            </SingleSubmitButton>
          </v-row>
        </v-form>
      </v-card-text>
    </v-card>
  </v-container>
</template>

<script lang="ts">
import { Component, Vue } from 'nuxt-property-decorator'
import { mdiEye, mdiEyeOff } from '@mdi/js'
import CardHeader from '~/components/ui/CardHeader.vue'
import RegisterStepper from '~/components/ui/RegisterStepper.vue'
import redirectIfNotValidCondition from '~/middleware/redirectIfNotValidCondition'
import {
  email_rules,
  family_name_rules,
  family_name_yomi_rules,
  last_name_rules,
  last_name_yomi_rules,
  password_rules,
  phone_number_rules
} from '~/utils/rules'
import { VFormInterface } from '~/interface/VFormInterface'
import SingleSubmitButton from '~/components/ui/SingleSubmitButton.vue'
import redirectIfAuthenticated from '~/middleware/redirectIfAuthenticated'
import { ToasterStore } from '~/utils/store-accsessor'

@Component({
  middleware: [redirectIfNotValidCondition, redirectIfAuthenticated],
  components: {
    SingleSubmitButton,
    CardHeader,
    RegisterStepper
  },
  head: {
    title: 'アカウント作成'
  }
})
export default class UserCreate extends Vue {
  step = 2

  email = ''
  password = ''
  password_confirmation = ''
  family_name = ''
  given_name = ''
  family_name_yomi = ''
  given_name_yomi = ''
  phone_number = ''
  confirm_terms = false

  show_password = false
  show_password_confirmation = false

  mdi_eye = mdiEye
  mdi_eye_off = mdiEyeOff

  email_rules = email_rules
  password_rules = password_rules
  password_confirmation_rules = (password: string) => [
    (password_confirmation: string): boolean | string =>
      !!password_confirmation || 'パスワードを再入力してください.',
    (password_confirmation: string): boolean | string =>
      password_confirmation === password || 'パスワードが一致しません.'
  ]

  family_name_rules = family_name_rules
  last_name_rules = last_name_rules
  family_name_yomi_rules = family_name_yomi_rules
  last_name_yomi_rules = last_name_yomi_rules
  phone_number_rules = phone_number_rules

  mounted () {
    this.$axios.$get('/sanctum/csrf-cookie')
  }

  async submit () {
    if ((this.$refs.form as VFormInterface).validate()) {
      await this.$axios.$get('/sanctum/csrf-cookie')
      await this.$axios
        .$post('/auth/register', {
          family_name: this.family_name,
          given_name: this.given_name,
          family_name_yomi: this.family_name_yomi,
          given_name_yomi: this.given_name_yomi,
          email: this.email,
          password: this.password,
          password_confirmation: this.password_confirmation,
          phone_number: this.phone_number,
          terms: this.confirm_terms
        })
        .then(() => {
          this.$auth
            .loginWith('laravelSanctum', {
              data: {
                email: this.email,
                password: this.password
              }
            })
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
