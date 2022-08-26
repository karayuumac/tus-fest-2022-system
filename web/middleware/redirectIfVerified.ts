import { Context } from '@nuxt/types'

export default function redirectIfVerified ({ store, redirect }: Context) {
  if (!store.$auth.user) {
    redirect('/user/login')
    return
  }
  // @ts-ignore
  if (store.$auth.user.data.has_email_verified) {
    redirect('/home')
  }
}
