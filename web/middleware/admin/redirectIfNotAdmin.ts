import { Context } from '@nuxt/types'
import { ToasterStore } from '~/utils/store-accsessor'

export default function redirectIfNotAdmin ({ $auth, redirect }: Context) {
  // @ts-ignore
  if (!$auth.user.data.is_admin) {
    ToasterStore.setToast({
      message: '権限がありません',
      timeout: 3000,
      color: 'error'
    })
    redirect('/home')
  }
}
