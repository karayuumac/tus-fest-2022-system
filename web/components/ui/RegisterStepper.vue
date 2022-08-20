<template>
  <v-stepper alt-labels outlined>
    <v-stepper-header v-model="step">
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
        予約
      </v-stepper-step>
    </v-stepper-header>
  </v-stepper>
</template>

<script lang="ts">
import { Component, Model, Vue } from 'nuxt-property-decorator'

@Component
export default class RegisterStepper extends Vue {
  @Model('update', { type: Number, required: true }) step!: number
}
</script>

<style lang="scss" scoped>

</style>
