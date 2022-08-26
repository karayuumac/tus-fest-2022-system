import { Context } from '@nuxt/types'
import { ToasterStore } from '~/utils/store-accsessor'

export default function redirectIfNotVerified ({ store, redirect }: Context) {
  if (!store.$auth.user) {
    ToasterStore.setToast({
      message: 'ログインしてください',
      timeout: 3000,
      color: 'error'
    })
    redirect('/user/login')
    return
  }
  // @ts-ignore
  if (!store.$auth.user.data.has_email_verified) {
    redirect('/user/verified')
  }
}
