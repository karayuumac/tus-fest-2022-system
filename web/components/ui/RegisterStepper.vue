<template>
  <div class="stepper">
    <v-stepper v-model="step" min-width="350" alt-labels outlined>
      <v-stepper-header>
        <v-stepper-step
          step="1"
          :complete="step > 1"
        >
          条件の確認
        </v-stepper-step>

        <v-divider />

        <v-stepper-step
          step="2"
          :complete="step > 2"
        >
          ユーザー登録
        </v-stepper-step>

        <v-divider />

        <v-stepper-step
          step="3"
          :complete="step > 3"
        >
          <div class="text-center">
            メールアドレス<br>確認
          </div>
        </v-stepper-step>

        <v-divider />

        <v-stepper-step
          step="4"
          :complete="step > 4"
        >
          登録完了
        </v-stepper-step>
      </v-stepper-header>
    </v-stepper>
  </div>
</template>

<script lang="ts">
import { Component, Model, Vue } from 'nuxt-property-decorator'

@Component
export default class RegisterStepper extends Vue {
  @Model('update', { type: Number, required: true }) step!: number
}
</script>

<style lang="scss" scoped>
.stepper {
  overflow-x: auto;
  white-space: nowrap;
}
</style>
