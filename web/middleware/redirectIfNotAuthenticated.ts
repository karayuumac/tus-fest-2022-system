import { Context } from '@nuxt/types'
import { ToasterStore } from '~/utils/store-accsessor'

export default function redirectIfNotAuthenticated ({ store, redirect }: Context) {
  if (!store.$auth.loggedIn) {
    ToasterStore.setToast({
      message: 'ログインしてください',
      timeout: 3000,
      color: 'error'
    })
    redirect('/login')
  }
}
