import { Context } from '@nuxt/types'
import { ToasterStore } from '~/utils/store-accsessor'

export default async function redirectIfNotValidToken ({ params, $axios, redirect }: Context) {
  const token = params.token
  await $axios
    .$get(`/api/ticket/${token}`)
    .then((_) => {})
    .catch((err) => {
      ToasterStore.setToast({
        message: err.response.data.message,
        color: 'error',
        timeout: 3000
      })
      redirect('/')
    })
}
