/**
 * urlにcondition=trueクエリが存在しない場合にリダイレクトさせる
 *
 * @param query
 * @param redirect
 */
import { Context } from '@nuxt/types'

export default function ({ query, redirect }: Context) {
  if (!query.condition) {
    redirect('/register/condition')
  }
}
