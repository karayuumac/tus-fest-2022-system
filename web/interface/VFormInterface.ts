import Vue from 'vue'

export interface VFormInterface extends Vue {
  reset (): void

  resetValidation (): void

  validate (): boolean
}
