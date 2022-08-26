import { Context } from '@nuxt/types'
import { ToasterStore } from '~/utils/store-accsessor'

export default function redirectIfAuthenticated ({ store, redirect }: Context) {
  if (store.$auth.loggedIn) {
    ToasterStore.setToast({
      message: 'すでにログインしています',
      timeout: 3000,
      color: 'error'
    })
    redirect('/home')
  }
}
