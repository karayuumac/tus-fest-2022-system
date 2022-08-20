import { Module, Mutation, VuexModule } from 'vuex-module-decorators'

export type Toast = {
  message: string | null
  color: string
  timeout: number
}

@Module({
  name: 'toaster',
  stateFactory: true,
  namespaced: true
})
export default class ToasterModule extends VuexModule {
  private toast: Toast = {
    message: null,
    color: 'error',
    timeout: 4000
  }

  get getToast (): Toast {
    return this.toast
  }

  @Mutation
  setToast (toast: Toast): void {
    this.toast = toast
  }

  @Mutation
  resetToast (): void {
    this.toast = {
      message: null,
      color: 'error',
      timeout: 4000
    }
  }
}
