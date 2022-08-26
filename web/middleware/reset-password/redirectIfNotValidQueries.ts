import { Context } from '@nuxt/types'

export default function redirectIfNotValidQueries ({ query, redirect }: Context) {
  if (!query.email || !query.token) {
    redirect('/')
  }
}
