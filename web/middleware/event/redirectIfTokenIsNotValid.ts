import { Context } from '@nuxt/types'

export default function ({ query, params, redirect, $axios }: Context) {
  if (!query.token) {
    redirect(`/event/${params.id}`)
  }
  $axios.$post(`/api/event/${params.id}/seat/validate`, {
    token: query.token
  })
    .then((_) => {})
    .catch((_) => {
      redirect(`/event/${params.id}`)
    })
}
