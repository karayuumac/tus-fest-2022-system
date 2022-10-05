import { Context } from '@nuxt/types'
import { ToasterStore } from '~/utils/store-accsessor'

export default async function redirectIfNotOwnToken ({ params, $axios, redirect }: Context) {
  const id = params.id
  await $axios
    .$get(`/api/ticket/${id}/send`)
    .then((_) => {
    })
    .catch((err) => {
      console.info(err)
      ToasterStore.setToast({
        message: '権限がありません',
        timeout: 3000,
        color: 'error'
      })
      redirect('/home')
    })
}
