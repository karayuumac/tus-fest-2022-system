import { Context } from '@nuxt/types'
import { ToasterStore } from '~/utils/store-accsessor'

export default async function redirectIfNotApplication ({ params, $axios, redirect }: Context) {
  const event_id = params.id
  await $axios
    .$get(`/api/event/${event_id}`)
    .then((res) => {
      return res.event
    })
    .catch(() => {
      ToasterStore.setToast({
        message: '権限がありません',
        timeout: 3000,
        color: 'error'
      })
      redirect('/home')
    })
}
